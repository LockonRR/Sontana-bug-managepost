import React, { useState } from "react";
import { useForm } from "@inertiajs/react";

export default function Edit({ post, categories }) {
    const { data, setData, put, processing, errors } = useForm({
        title: post.title,
        content: post.content,
        category_id: post.category_id,
        image: null,
    });

    const [previewImage, setPreviewImage] = useState(post.image ? `/storage/${post.image}` : null);

    // เช็คการเปลี่ยนแปลงข้อมูล
    const handleChange = (e) => {
        setData(e.target.name, e.target.value);
        console.log("Updated form data:", { ...data, [e.target.name]: e.target.value });
    };

    // เช็คการเลือกไฟล์
    const handleFileChange = (e) => {
        const file = e.target.files[0];
        setData("image", file);

        if (file) {
            setPreviewImage(URL.createObjectURL(file));
            console.log("File selected:", file);
        }
    };

    // ใช้ async/await แทน then() ในการส่งข้อมูล
    const handleSubmit = async (e) => {
        e.preventDefault();
    
        const formData = new FormData();
        formData.append("title", data.title);
        formData.append("content", data.content);
        formData.append("category_id", data.category_id);
    
        if (data.image) {
            formData.append("image", data.image);
        } else {
            formData.append("image", null);
        }

        // เช็คข้อมูลก่อนส่ง
        console.log("Form data to be submitted:", formData);
    
        try {
            // ใช้ async/await แทน then()
            const response = await put(route("post.update", post.id), {
                data: formData,
                preserveScroll: true,
            });
            console.log("Post updated successfully:", response);
        } catch (error) {
            console.error("Error updating post:", error);
        }
    };

    return (
        <div className="flex justify-center items-center min-h-screen bg-black">
            <div className="w-full max-w-2xl p-8 backdrop-blur-md bg-blue-950 border border-white/20 rounded-2xl shadow-xl">
                <h1 className="text-3xl font-semibold text-white text-center mb-6">✨ Edit Post</h1>
                <form onSubmit={handleSubmit} className="space-y-6">
                    <div>
                        <label className="block text-gray-300 font-medium mb-1">Title</label>
                        <input
                            type="text"
                            name="title"
                            value={data.title}
                            onChange={handleChange}
                            className="w-full px-4 py-3 bg-transparent border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        />
                        {errors.title && <p className="text-red-500 text-sm mt-1">{errors.title}</p>}
                    </div>

                    <div>
                        <label className="block text-gray-300 font-medium mb-1">Category</label>
                        <select
                            name="category_id"
                            value={data.category_id}
                            onChange={handleChange}
                            className="w-full px-4 py-3 bg-transparent border border-gray-500 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                        >
                            <option value="" disabled>Select a category</option>
                            {categories.map((category) => (
                                <option key={category.id} value={category.id} className="text-black">
                                    {category.name}
                                </option>
                            ))}
                        </select>
                        {errors.category_id && <p className="text-red-500 text-sm mt-1">{errors.category_id}</p>}
                    </div>

                    <div>
                        <label className="block text-gray-300 font-medium mb-1">Content</label>
                        <textarea
                            name="content"
                            value={data.content}
                            onChange={handleChange}
                            rows="4"
                            className="w-full px-4 py-3 bg-transparent border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        ></textarea>
                        {errors.content && <p className="text-red-500 text-sm mt-1">{errors.content}</p>}
                    </div>

                    <div>
                        
                        {previewImage && (
                            <div className="mt-3">
                                <p className="text-gray-400 text-sm">Current Image:</p>
                                <img src={previewImage} alt="Post Preview" className="w-full h-full object-cover mt-2 rounded-lg" />
                            </div>
                        )}
                        {errors.image && <p className="text-red-500 text-sm mt-1">{errors.image}</p>}
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full py-3 px-4 rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold shadow-lg hover:scale-105 transition transform focus:outline-none focus:ring-2 focus:ring-blue-400"
                    >
                        {processing ? "Processing..." : "Update Post"}
                    </button>
                </form>
            </div>
        </div>
    );
}

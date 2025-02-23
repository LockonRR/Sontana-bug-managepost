import React from "react";
import { useForm } from "@inertiajs/react";

export default function Create({ categories }) {
    const { data, setData, post, processing, errors } = useForm({
        title: "",
        content: "",
        category_id: "",
        image: null,
    });

    const handleChange = (e) => {
        setData(e.target.name, e.target.value);
    };

    
    const handleFileChange = (e) => {
        setData("image", e.target.files[0]);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("post.store")); // ส่งข้อมูลไปยัง Controller ผ่าน Inertia.js
    };

    return (
        <div className="flex justify-center items-center min-h-screen bg-black">
            <div className="w-full max-w-2xl p-8 backdrop-blur-md bg-blue-950 border border-white/20 rounded-2xl shadow-xl">
                <h1 className="text-3xl font-semibold text-white text-center mb-6">
                    ✨ Create New Post
                </h1>
                <form onSubmit={handleSubmit} className="space-y-6">
                    <div>
                        <label className="block text-gray-300 font-medium mb-1">
                            Title
                        </label>
                        <input
                            type="text"
                            name="title"
                            value={data.title}
                            onChange={handleChange}
                            className="w-full px-4 py-3 bg-transparent border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        />
                        {errors.title && <p className="text-red-500">{errors.title}</p>}
                    </div>

                    <div>
                        <label className="block text-gray-300 font-medium mb-1">
                            Category
                        </label>
                        <select
                            name="category_id"
                            value={data.category_id}
                            onChange={handleChange}
                            className="w-full px-4 py-3 bg-transparent border border-gray-500 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                        >
                            <option value="" disabled>
                                Select a category
                            </option>
                            {categories.map((category) => (
                                <option key={category.id} value={category.id} className="text-black">
                                    {category.name}
                                </option>
                            ))}
                        </select>
                        {errors.category_id && <p className="text-red-500">{errors.category_id}</p>}
                    </div>

                    <div>
                        <label className="block text-gray-300 font-medium mb-1">
                            Content
                        </label>
                        <textarea
                            name="content"
                            value={data.content}
                            onChange={handleChange}
                            rows="4"
                            className="w-full px-4 py-3 bg-transparent border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        ></textarea>
                        {errors.content && <p className="text-red-500">{errors.content}</p>}
                    </div>

                    <div>
                        <label className="block text-gray-300 font-medium mb-1">
                            Upload Image:
                        </label>
                        <input
                            type="file"
                            accept="image/*"
                            onChange={handleFileChange}
                            className="rounded-md border border-gray-300 p-2 flex text-gray-300 w-full"
                        />
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full py-3 px-4 rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold shadow-lg hover:scale-105 transition transform focus:outline-none focus:ring-2 focus:ring-blue-400"
                    >
                        {processing ? "Processing..." : "Create Now"}
                    </button>
                </form>
            </div>
        </div>
    );
}

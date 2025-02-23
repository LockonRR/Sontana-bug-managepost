import React, { useState } from "react";
import { useForm } from "@inertiajs/react";

export default function Create({ categories }) {
    const { data, setData, post, processing, errors } = useForm({
        title: "",
        content: "",
        category_id: "",
        image: null,
    });

    const [preview, setPreview] = useState(null);

    const handleChange = (e) => {
        setData(e.target.name, e.target.value);
    };

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        setData("image", file);

        if (file) {
            setPreview(URL.createObjectURL(file));
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("post.store"));
    };

    return (
        <div className="flex justify-center items-center min-h-screen bg-gray-100">
            <div className="w-full max-w-lg p-6 bg-white border border-gray-300 rounded-lg shadow-md">
                <h1 className="text-2xl font-semibold text-gray-800 text-center mb-4">
                    ✨ Create New Post
                </h1>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-gray-700 font-medium mb-1">
                            Title
                        </label>
                        <input
                            type="text"
                            name="title"
                            value={data.title}
                            onChange={handleChange}
                            className="w-full px-3 py-2 border border-gray-300 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-blue-400"
                        />
                        {errors.title && (
                            <p className="text-red-500 text-sm">
                                {errors.title}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="block text-gray-700 font-medium mb-1">
                            Category
                        </label>
                        <select
                            name="category_id"
                            value={data.category_id}
                            onChange={handleChange}
                            className="w-full px-3 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        >
                            <option value="" disabled>
                                Select a category
                            </option>
                            {categories.map((category) => (
                                <option
                                    key={category.id}
                                    value={category.id}
                                    className="text-gray-800"
                                >
                                    {category.name}
                                </option>
                            ))}
                        </select>
                        {errors.category_id && (
                            <p className="text-red-500 text-sm">
                                {errors.category_id}
                            </p>
                        )}
                    </div>

                    <div>
                        <label className="block text-gray-700 font-medium mb-1">
                            Content
                        </label>
                        <textarea
                            name="content"
                            value={data.content}
                            onChange={handleChange}
                            rows="4"
                            className="w-full px-3 py-2 border border-gray-300 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        ></textarea>
                        {errors.content && (
                            <p className="text-red-500 text-sm">
                                {errors.content}
                            </p>
                        )}
                    </div>

                    <div className="w-full">
                        <label className="block text-gray-700 font-medium mb-2">
                            Upload Image:
                        </label>
                        <div
                            className="relative flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 cursor-pointer transition"
                            onClick={() =>
                                document.getElementById("imageUpload").click()
                            }
                        >
                            {preview ? (
                                <img
                                    src={preview}
                                    alt="Preview"
                                    className="absolute inset-0 w-full h-full object-contain rounded-lg"
                                />
                            ) : (
                                <div className="text-gray-500 text-center">
                                    <p className="text-sm">
                                        Click to upload image
                                    </p>
                                    <p className="text-xs">
                                        PNG, JPG, JPEG (Max: 5MB)
                                    </p>
                                </div>
                            )}
                        </div>
                        <input
                            id="imageUpload"
                            type="file"
                            accept="image/*"
                            onChange={handleFileChange}
                            className="hidden"
                        />
                        {errors.image && (
                            <p className="text-red-500 text-sm mt-2">
                                {errors.image}
                            </p>
                        )}
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full py-2 px-4 rounded-lg bg-blue-500 text-white font-semibold shadow-md hover:bg-blue-600 transition transform focus:outline-none focus:ring-2 focus:ring-blue-400"
                    >
                        {processing ? "Processing..." : "Create Now"}
                    </button>
                </form>
            </div>
        </div>
    );
}

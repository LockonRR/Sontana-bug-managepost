import React, { useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import SideNavFront from "@/Components/SideNavBarFront";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

export default function PostIndex() {
    const { posts, categories, currentSort, selectedCategory } =
        usePage().props;
    const [sortOrder, setSortOrder] = useState(currentSort);

    const handleSortChange = () => {
        const newSortOrder = sortOrder === "desc" ? "asc" : "desc";
        setSortOrder(newSortOrder);
        // เปลี่ยน query string ตามลำดับที่เลือก
        window.location.search = `?sort=${newSortOrder}&category_id=${
            selectedCategory?.id || ""
        }`;
    };

    return (
        <AuthenticatedLayout>
            {/* ปุ่มสร้างโพสต์ */}
            <Link
                href={route("post.create")}
                className="fixed top-20 right-5 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition z-30 md:z-20"
            >
                + Create Post
            </Link>
            {/* ปุ่มสลับการเรียงลำดับโพสต์ */}
            <button
                onClick={handleSortChange}
                className="fixed top-32 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition z-30 md:z-20"
            >
                {sortOrder === "desc" ? "Newest First" : "Oldest First"}
            </button>

            <div className="flex justify-center items-center min-h-screen bg-gray-100 p-5">
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4 w-full max-w-7xl">
                    <SideNavFront
                        categories={categories}
                        className="md:block hidden"
                    />

                    <div className="bg-white p-6 mt-5 rounded-lg shadow-md col-span-3">
                        <h1 className="text-2xl font-bold text-gray-800 mb-6">
                            Blog Posts
                        </h1>

                        {posts.length > 0 ? (
                            posts.map((post) => (
                                <Link
                                    key={post.id}
                                    href={route("post.show", { id: post.id })}
                                    className="block bg-white rounded-lg shadow-md p-6 mb-6 transition transform  hover:shadow-lg"
                                >
                                    {/* แสดงรูปภาพของโพสต์ */}
                                    {post.image && (
                                        <img
                                            src={`/storage/${post.image}`}
                                            alt={post.title}
                                            className="w-full h-64 object-contain rounded-lg mb-4"
                                        />
                                    )}

                                    <h2 className="text-2xl font-semibold text-gray-900 mb-2">
                                        {post.title}
                                    </h2>
                                    <p className="italic text-gray-600">
                                        <strong>Category:</strong>{" "}
                                        {post.category.name}
                                    </p>
                                    <p className="text-gray-700 leading-relaxed mb-4">
                                        {post.content}
                                    </p>
                                    <p className="text-gray-600">
                                        <strong>Author:</strong>{" "}
                                        {post.user.name}
                                    </p>
                                </Link>
                            ))
                        ) : (
                            <p className="text-center text-gray-600">
                                No posts available.
                            </p>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

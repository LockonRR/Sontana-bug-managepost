import React from "react";
import { Link, usePage } from "@inertiajs/react";
import SideNavFront from "@/Components/SideNavBarFront";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

export default function PostIndex() {
    const { posts, categories } = usePage().props;

    return (
        <AuthenticatedLayout>
            {/* ปุ่มสร้างโพสต์ */}
            <Link
                href={route("post.create")}
                className="fixed top-20 right-5 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition"
            >
                + Create Post
            </Link>

            <div className="grid grid-cols-1 md:grid-cols-4 gap-4 p-5 font-sans bg-gray-100 min-h-screen">
                <SideNavFront
                    categories={categories}
                    className="md:block hidden"
                />

                <div className="col-span-1 md:col-span-3 bg-white p-6 mt-5 rounded-lg shadow-md">
                    <h1 className="text-2xl font-bold text-gray-800 mb-6">
                        Blog Posts
                    </h1>

                    {posts.length > 0 ? (
                        posts.map((post) => (
                            <Link
                                key={post.id}
                                href={route("post.show", { id: post.id })}
                                className="block bg-white rounded-lg shadow-md p-6 mb-6 max-w-2xl transition transform hover:scale-105 hover:shadow-lg"
                            >
                                {/* แสดงรูปภาพของโพสต์ */}
                                {post.image && (
                                    <img
                                        src={`/storage/${post.image}`}
                                        alt={post.title}
                                        className="w-full h-64 object-cover rounded-lg mb-4"
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
                                    <strong>Author:</strong> {post.user.name}
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
        </AuthenticatedLayout>
    );
}

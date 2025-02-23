import React, { useState, useEffect } from "react";
import SideNavBar from "@/Components/SideNavBar";
import { Link, usePage } from "@inertiajs/react"; // ✅ ใช้ Link ของ Inertia.js และ usePage เพื่อเข้าถึง router

const ManagePosts = () => {
    const [posts, setPosts] = useState([]);
    const [selectedPosts, setSelectedPosts] = useState([]);
    const { router } = usePage(); // ใช้ usePage() เพื่อเข้าถึง router

    useEffect(() => {
        fetchPosts();
    }, []);

    const fetchPosts = async () => {
        try {
            const response = await fetch("/sontana/posts", {
                headers: { Accept: "application/json" },
            });
            if (!response.ok) throw new Error("Failed to fetch posts");
            const data = await response.json();
            setPosts(data);
        } catch (error) {
            console.error("Error fetching posts:", error);
        }
    };

    const handleDelete = (postId) => {
        if (router) {
            // เรียกใช้ router.delete เพื่อลบโพสต์
            router.delete(route("post.destroyer", postId));
        } else {
            console.error("Router not available.");
        }
    };

    const handleCardClick = (id) => {
        setSelectedPosts((prevSelectedPosts) =>
            prevSelectedPosts.includes(id)
                ? prevSelectedPosts.filter((postId) => postId !== id)
                : [...prevSelectedPosts, id]
        );
    };

    return (
        <div className="md:flex bg-gray-100 min-h-screen">
            <SideNavBar />
            <div className="flex-1 p-6 md:ml-64">
                <h1 className="text-2xl font-bold">Manage Posts</h1>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    {posts.map((post) => (
                        <div
                            key={post.id}
                            className={`bg-white shadow-md rounded-lg p-4 relative cursor-pointer ${
                                selectedPosts.includes(post.id)
                                    ? "bg-gray-200"
                                    : ""
                            }`}
                            onClick={() => handleCardClick(post.id)}
                        >
                            <h3 className="text-lg font-semibold">
                                {post.title}
                            </h3>
                            <p className="text-gray-600">
                                Author: {post.author}
                            </p>
                            <div className="mt-4 flex justify-end space-x-2">
                                <Link
                                    href={`sontana/posts/${post.id}`}
                                    className="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"
                                >
                                    View
                                </Link>

                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default ManagePosts;

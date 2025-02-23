import React, { useState, useEffect } from "react";
import SideNavBar from "@/Components/SideNavBar";

const ManagePosts = () => {
    const [posts, setPosts] = useState([]);
    const [selectedPosts, setSelectedPosts] = useState([]); // สถานะสำหรับเก็บโพสต์ที่ถูกเลือก

    useEffect(() => {
        fetchPosts();
    }, []);

    const fetchPosts = async () => {
        try {
            const response = await fetch("/sontana/posts", {
                headers: { Accept: "application/json" }, // บอก Laravel ว่าขอ JSON
            });
            if (!response.ok) throw new Error("Failed to fetch posts");
            const data = await response.json();
            setPosts(data); // สมมติว่ามี useState สำหรับ posts
        } catch (error) {
            console.error("Error fetching posts:", error);
        }
    };

    // เรียก fetchPosts() ตอน Component โหลด
    useEffect(() => {
        fetchPosts();
    }, []);

    const handleDelete = async () => {
        if (selectedPosts.length === 0) {
            alert("Please select at least one post to delete.");
            return;
        }

        if (
            window.confirm(
                "Are you sure you want to delete the selected posts?"
            )
        ) {
            try {
                // ลบโพสต์ทั้งหมดที่เลือก
                for (let id of selectedPosts) {
                    const response = await fetch(`/api/posts/${id}`, {
                        method: "DELETE",
                    });
                    if (!response.ok)
                        throw new Error(`Failed to delete post with id ${id}`);
                }
                // อัพเดตสถานะ posts หลังจากลบ
                setPosts(
                    posts.filter((post) => !selectedPosts.includes(post.id))
                );
                setSelectedPosts([]); // เคลียร์การเลือกโพสต์
            } catch (error) {
                console.error("Error deleting posts:", error);
            }
        }
    };

    const handleCardClick = (id) => {
        // การเลือก/ยกเลิกเลือกโพสต์
        setSelectedPosts((prevSelectedPosts) =>
            prevSelectedPosts.includes(id)
                ? prevSelectedPosts.filter((postId) => postId !== id)
                : [...prevSelectedPosts, id]
        );
    };

    const handleView = (post) => {
        console.log("Viewing Post:", post);
        alert(`Post Title: ${post.title}\nAuthor: ${post.author}`);
    };

    return (
        <div className="md:flex bg-gray-100 min-h-screen">
            <SideNavBar />

            <div className="flex-1 p-6 md:ml-64">
                <h1 className="text-2xl font-bold">
                    Welcome to the Manage Posts Panel
                </h1>
                {/* 🛑 Layout เปลี่ยนเป็น Grid ของ Card */}
                <div className="mt-4 flex space-x-2 justify-end">
                    <button className="justify-end bg-red-500 text-white px-4 py-2 rounded">
                        delete
                    </button>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    {posts.map((post) => (
                        <div
                            key={post.id}
                            className={`bg-white shadow-md rounded-lg p-4 relative cursor-pointer ${
                                selectedPosts.includes(post.id)
                                    ? "bg-gray-200"
                                    : ""
                            }`}
                            onClick={() => handleCardClick(post.id)} // เมื่อคลิกการ์ด
                        >
                            {selectedPosts.includes(post.id) && (
                                <div className="absolute top-0 right-0 p-2">
                                    <span className="text-green-500 text-xl">
                                        ✅
                                    </span>
                                </div>
                            )}
                            <h3 className="text-lg font-semibold">
                                {post.title}
                            </h3>
                            <p className="text-gray-600">
                                Author: {post.author}
                            </p>

                            {/* 🔹 ปุ่ม Actions */}
                            <div className="mt-4 flex justify-end space-x-2">
                                <button
                                    onClick={() => handleView(post)}
                                    className="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"
                                >
                                    View
                                </button>
                                <button className="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                    Edit
                                </button>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default ManagePosts;

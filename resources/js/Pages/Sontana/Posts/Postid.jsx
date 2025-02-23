import { router } from "@inertiajs/react";
import React, { useState } from "react";
import { usePage, Link } from "@inertiajs/react";
import SideNavFront from "@/Components/SideNavBarFront";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

export default function PostDetail() {
    const { post, auth, categories } = usePage().props;
    const [comment, setComment] = useState("");
    const [comments, setComments] = useState(post.comments || []);

    const handleDelete = (postId) => {
        if (confirm("Are you sure you want to delete this post?")) {
            router.delete(route("post.destroy", postId));
        }
    };

    // ✅ เพิ่มฟังก์ชัน handleSubmit
    const handleSubmit = (e) => {
        e.preventDefault();
        router.post(
            route("comment.store", post.id),
            { content: comment },
            {
                onSuccess: (page) => {
                    setComments(page.props.comments || []);
                    setComment("");
            window.location.reload();
                },
            }
        );
    };

    return (
        <AuthenticatedLayout>
            <div className="grid grid-cols-4 gap-4 p-5 font-sans bg-gray-100 min-h-screen">
                <SideNavFront categories={categories} />
                <div className="col-span-3 bg-white p-6 mt-5 rounded-lg shadow-md">
                    {post.image && (
                        <img
                            src={`/storage/${post.image}`}
                            alt={post.title}
                            className="w-full h-64 object-cover rounded-lg mb-4"
                        />
                    )}
                    <h1 className="text-5xl font-bold text-gray-800 mb-6">
                        {post.title}
                    </h1>

                    {auth.user && auth.user.id === post.user_id && (
                        <div className="flex space-x-4 mt-6">
                            <Link
                                href={route("post.edit", post.id)}
                                className="px-4 py-2 bg-yellow-500 text-white rounded-lg"
                            >
                                Edit
                            </Link>
                            <button
                                onClick={() => handleDelete(post.id)}
                                className="px-4 py-2 bg-red-500 text-white rounded-lg"
                            >
                                Delete
                            </button>
                        </div>
                    )}

                    {/* ฟอร์มเพิ่มคอมเมนต์ */}
                    {auth.user && (
                        <form onSubmit={handleSubmit} className="mt-6">
                            <textarea
                                className="w-full p-3 border rounded-lg"
                                value={comment}
                                onChange={(e) => setComment(e.target.value)}
                                placeholder="Write a comment..."
                                required
                            />
                            <button
                                type="submit"
                                className="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg"
                            >
                                Add Comment
                            </button>
                        </form>
                    )}

                    {/* แสดงคอมเมนต์ */}
                    <div className="mt-8">
                        <h2 className="text-2xl font-semibold">Comments</h2>
                        {comments.length > 0 ? (
                            comments.map((comment) => (
                                <div
                                    key={comment.id}
                                    className="mt-4 p-4 bg-gray-200 rounded-lg"
                                >
                                    <p className="font-bold">
                                        {comment.user?.name || "Unknown User"}:
                                    </p>
                                    <p>{comment.content}</p>
                                </div>
                            ))
                        ) : (
                            <p className="text-gray-500">No comments yet.</p>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

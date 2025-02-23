import React, { useState } from "react";
import SideNavBar from "@/Components/SideNavBar";

const AdminPanel = ({ users = [] }) => {
    const [selectedUsers, setSelectedUsers] = useState([]);

    const handleAction = (action) => {
        console.log(
            `Selected Users: ${selectedUsers.join(", ")}, Action: ${action}`
        );
    };

    const toggleUserSelection = (userId) => {
        setSelectedUsers((prevSelected) =>
            prevSelected.includes(userId)
                ? prevSelected.filter((id) => id !== userId)
                : [...prevSelected, userId]
        );
    };

    return (
        <div className="md:flex">
            <SideNavBar />
            <div className="flex-1 p-4 md:ml-64">
                <h1 className="text-2xl font-bold">User Management Panel</h1>
                <div className="mt-4 flex justify-end space-x-2">
                    <button
                        className="bg-red-500 text-white px-4 py-2 rounded"
                        onClick={() => handleAction("ban")}
                    >
                        Ban
                    </button>
                    <button
                        className="bg-yellow-500 text-white px-4 py-2 rounded"
                        onClick={() => handleAction("temporary")}
                    >
                        Temporary Ban
                    </button>
                    <button
                        className="bg-green-500 text-white px-4 py-2 rounded"
                        onClick={() => handleAction("unban")}
                    >
                        Unban
                    </button>
                </div>
                <div className="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    {users.length > 0 ? (
                        users.map((user) => (
                            <div
                                key={user.id}
                                className={`relative p-4 border rounded shadow cursor-pointer ${
                                    selectedUsers.includes(user.id)
                                        ? "bg-gray-200"
                                        : ""
                                }`}
                                onClick={() => toggleUserSelection(user.id)}
                            >
                                {selectedUsers.includes(user.id) && (
                                    <div className="absolute top-0 right-0 p-2">
                                        <span className="text-green-500 text-xl">
                                            ✅
                                        </span>
                                    </div>
                                )}
                                <h2 className="text-xl font-semibold">
                                    {user.name}
                                </h2>
                                <p className="text-gray-600">{user.email}</p>
                                <p className="text-gray-600">
                                    Posts: {user.posts_count ?? 0}
                                </p>
                                <p className="text-gray-600">
                                    Reported: {user.reports_received_count ?? 0}
                                </p>
                                <p className="text-gray-600">
                                    Send Reports: {user.reports_sent_count ?? 0}
                                </p>
                            </div>
                        ))
                    ) : (
                        <p>No users available</p>
                    )}
                </div>
            </div>
        </div>
    );
};

export default AdminPanel;
 
import React, { useState, useEffect } from "react";
import SideNavBar from "@/Components/SideNavBar";

const Dashboard = ({ totalUsers, totalPosts, totalReports, usersToday }) => {
  // Initialize state using the props from Inertia
  const [data, setData] = useState({
    totalUsers: totalUsers || 0,
    totalPosts: totalPosts || 0,
    totalReports: totalReports || 0,
    totalBannedUsers: 0,
    usersToday: usersToday || [],
  });

  // State for search term
  const [searchTerm, setSearchTerm] = useState("");

  // If the props might update over time, update state accordingly.
  useEffect(() => {
    setData({
      totalUsers: totalUsers || 0,
      totalPosts: totalPosts || 0,
      totalReports: totalReports || 0,
      totalBannedUsers: 0,
      usersToday: usersToday || [],
    });
  }, [totalUsers, totalPosts, totalReports, usersToday]);

 // Filtered users based on search term (name or email)
 const filteredUsers = data.usersToday.filter((user) =>
    user.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
    user.email.toLowerCase().includes(searchTerm.toLowerCase())
  );
  return (
    <div className="md:flex bg-gray-100 min-h-screen">
      <SideNavBar />
      <div className="flex-1 p-6 md:ml-64">
        <h1 className="text-2xl font-bold mb-4">Welcome to the Dashboard Posts Panel</h1>
        <p className="mt-4">
          This is the main content area. Replace this with your actual content.
        </p>


        {/* Cards Section */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div className="bg-blue-500 text-white p-6 rounded-lg shadow-md">
            <h3 className="text-lg font-semibold">Total Users</h3>
            <p className="text-3xl font-bold">{data.totalUsers}</p>
          </div>
          <div className="bg-green-500 text-white p-6 rounded-lg shadow-md">
            <h3 className="text-lg font-semibold">Total Posts</h3>
            <p className="text-3xl font-bold">{data.totalPosts}</p>
          </div>
          <div className="bg-yellow-500 text-white p-6 rounded-lg shadow-md">
            <h3 className="text-lg font-semibold">Total Reports</h3>
            <p className="text-3xl font-bold">{data.totalReports}</p>
          </div>
          <div className="bg-red-500 text-white p-6 rounded-lg shadow-md">
            <h3 className="text-lg font-semibold">Total Banned Users</h3>
            <p className="text-3xl font-bold">{data.totalBannedUsers}</p>
          </div>
        </div>

        {/* Users Table */}
        <div className="mt-6 bg-white p-4 rounded-lg shadow-md">
              {/* Search Input */}
        <input
          className="mb-4 p-2 border rounded w-full"
          type="search"
          placeholder="ค้นหาผู้ใช้งาน..."
          value={searchTerm}
          onChange={(e) => setSearchTerm(e.target.value)}
        />
          <h2 className="text-xl font-semibold mb-4">ผู้ที่ใช้งานทั้งหมด</h2>
          <table className="w-full border-collapse border border-gray-300">
            <thead>
              <tr className="bg-gray-200">
                <th className="border p-2">ID</th>
                <th className="border p-2">ชื่อ-สกุล</th>
                <th className="border p-2">อีเมล</th>
                <th className="border p-2">จำนวนโพสต์</th>
                <th className="border p-2">สถานะ</th>
              </tr>
            </thead>
            <tbody>
              {filteredUsers.length > 0 ? (
                filteredUsers.map((user, index) => (
                  <tr key={user.id} className="text-center">
                    <td className="border p-2">{index + 1}</td>
                    <td className="border p-2">{user.name}</td>
                    <td className="border p-2">{user.email}</td>
                    <td className="border p-2">{user.posts_count ?? 0}</td>
                    <td className={`border p-2 font-semibold ${user.is_banned ? "text-red-500" : "text-green-500"}`}>
                      {user.is_banned ? "โดนแบน" : "ใช้งาน"}
                    </td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan="5" className="border p-2 text-center">No data found try again</td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;

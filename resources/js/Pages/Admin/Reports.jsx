import React, { useState } from 'react';
import SideNavBar from '@/Components/SideNavBar';

const userData = [
  { id: 1, name: 'User1', post_id: 101, count_report: 5, report_date_time: '2025-02-16 14:00', report_topic: 'เนื้อหามีความรุนแรง' },
  { id: 2, name: 'User2', post_id: 102, count_report: 3, report_date_time: '2025-02-16 13:30', report_topic: 'เนื้อหาหลองลวง' },
];

const Dashboard = () => {
  return (
    <div className="md:flex">
      <SideNavBar />
      <div className="flex-1 p-4 md:ml-64">
        <h1 className="text-2xl font-bold text-center">Welcome to Posts Reports Center</h1>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-14">
          {userData.map((user) => (
            <div key={user.id} className="relative p-4 bg-white shadow rounded">
              <span className="absolute top-0 left-0 p-2 bg-red-600 text-xs text-white rounded-full">{user.count_report} ครั้ง</span>
              <h2 className="text-xl font-semibold mt-4">Post id: {user.post_id}</h2>
              <p className="text-gray-600">Username: {user.name}</p>
              <p className="text-gray-600">Reported: {user.report_date_time}</p>
              <p className="text-gray-600">Report topic: {user.report_topic}</p>
              <div className='flex justify-start mt-4'>
                <button className='bg-transparent border border-solid border-blue-500 text-blue-500 px-2 py-2 rounded hover:bg-blue-500 hover:text-white active:bg-blue-600 font-bold uppercase text-xs'>
                  View Post
                </button>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default Dashboard;

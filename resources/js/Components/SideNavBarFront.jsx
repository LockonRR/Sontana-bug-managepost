import React from "react";
import { Inertia } from "@inertiajs/inertia";
const SideNavFront = ({ categories }) => {
    console.log("หมวดหมู่ที่ได้รับจาก Props:", categories);

    return (
        <div className="h-full w-100 bg-white p-4 md:col-span-1 hidden md:flex flex-col space-y-4 my-1 ml-10">
            <div className="fixed h-full w-64 bg-white p-4 flex flex-col space-y-4">
                {/* ส่วนรายการหมวดหมู่ */}
                <div className="flex flex-col space-y-2">
                    {categories && categories.length > 0 ? (
                        categories.map((category) => (
                            <p className="text-gray-700 cursor-pointer hover:bg-blue-200 p-2 rounded-lg" key={category.id}>
                                {category.name}
                            </p>
                        ))
                    ) : (
                        <p className="text-gray-500">ไม่มีหมวดหมู่</p>
                    )}
                </div>

            </div>
        </div>
    );
};

export default SideNavFront;

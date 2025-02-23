import React from "react";
import { Link } from "@inertiajs/react";

const SideNavFront = ({ categories }) => {
    console.log("หมวดหมู่ที่ได้รับจาก Props:", categories);

    return (
        <div className="h-full w-100 bg-white p-4 md:col-span-1 hidden md:flex flex-col space-y-4 ml-10 overflow-y-auto max-h-screen sticky top-24 mt-5 rounded-lg">
            {/* ส่วนรายการหมวดหมู่ */}
            <div className="flex flex-col space-y-2 ">
                {categories && categories.length > 0 ? (
                    categories.map((category) => (
                        <Link
                            key={category.id}
                            href={route("post.index", {
                                category_id: category.id,
                            })}
                            className="text-gray-700 cursor-pointer hover:bg-blue-200 p-2 rounded-lg"
                        >
                            {category.name}
                        </Link>
                    ))
                ) : (
                    <p className="text-gray-500">ไม่มีหมวดหมู่</p>
                )}
            </div>
        </div>
    );
};

export default SideNavFront;

import React, { useState } from "react";

const SideNavBar = () => {
    const [isOpen, setIsOpen] = useState(false);
    const [isReportsOpen, setIsReportsOpen] = useState(false);

    const toggleMenu = () => {
        setIsOpen(!isOpen);
    };

    const toggleReportsMenu = () => {
        setIsReportsOpen(!isReportsOpen);
    };

    return (
        <div className="flex">
            {/* Hamburger Menu for Mobile */}
            <div className="md:hidden bg-gray-800 text-white p-4 flex justify-between items-center w-full fixed top-0 z-50">
                <h2 className="text-xl">
                    <a href="/api/admindashboard">Admin Panel</a>
                </h2>
                <button onClick={toggleMenu} className="focus:outline-none">
                    <svg
                        className="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            strokeWidth="2"
                            d={
                                isOpen
                                    ? "M6 18L18 6M6 6l12 12"
                                    : "M4 6h16M4 12h16m-7 6h7"
                            }
                        ></path>
                    </svg>
                </button>
            </div>

            {/* Sidebar */}
            <div
                className={`fixed top-0 left-0 h-full w-64 bg-gray-800 text-white transition-transform duration-300 ease-in-out z-50
        ${
            isOpen ? "translate-x-0" : "-translate-x-full"
        } md:translate-x-0 overflow-y-auto`}
            >
                <ul className="mt-4">
                    <li className="px-4 text-xl">
                        <h2>
                            <a href="/">Admin Panel</a>
                        </h2>
                    </li>
                    <div className="mt-4">
                        <li className="px-4 py-2 hover:bg-gray-700">
                            <a href="/admindb" className="block w-full h-full">
                                Dashboard
                            </a>
                        </li>
                        <li className="px-4 py-2 hover:bg-gray-700">
                            <a
                                href="/manageposts"
                                className="block w-full h-full"
                            >
                                Manage Posts
                            </a>
                        </li>
                        <li className="px-4 py-2 hover:bg-gray-700">
                            <a
                                href="/usermanage"
                                className="block w-full h-full"
                            >
                                User Management
                            </a>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    );
};

export default SideNavBar;

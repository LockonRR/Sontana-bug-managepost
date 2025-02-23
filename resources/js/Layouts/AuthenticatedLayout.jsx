import ApplicationLogo from "@/Components/ApplicationLogo";
import Dropdown from "@/Components/Dropdown";
import NavLink from "@/Components/NavLink";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink";
import { Link, usePage } from "@inertiajs/react";
import { useState } from "react";

export default function AuthenticatedLayout({ header, children }) {
    const { user } = usePage().props.auth || {}; // ป้องกัน user เป็น null
    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);

    return (
        <div className="flex bg-gray-100 min-h-screen">
            {/* Main Content Area */}
            <div className="flex-1 flex flex-col">
                {/* Navbar */}
                <div className="fixed top-0 w-full bg-white border-b border-gray-200 z-10">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
                        {/* Left side */}
                        <div className="flex items-center">
                            <Link href="/" className="flex-shrink-0">
                                <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            </Link>
                            <NavLink
                                href={route("post.index")}
                                active={route().current("post.index")}
                                className="ml-10"
                            >
                                Homepage
                            </NavLink>
                        </div>

                        {/* Right side */}
                        <div className="hidden sm:flex sm:items-center">
                            <Dropdown>
                                <Dropdown.Trigger>
                                    <button className="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                        {user ? user.name : "Guest"}{" "}
                                        {/* ตรวจสอบว่า user มีค่าหรือไม่ */}
                                    </button>
                                </Dropdown.Trigger>
                                <Dropdown.Content>
                                    {user ? (
                                        <>
                                            <Dropdown.Link
                                                href={route("profile.edit")}
                                            >
                                                Profile
                                            </Dropdown.Link>
                                            <Dropdown.Link
                                                href={route("logout")}
                                                method="post"
                                                as="button"
                                            >
                                                Log Out
                                            </Dropdown.Link>
                                        </>
                                    ) : (
                                        <Dropdown.Link href={route("login")}>
                                            Log In
                                        </Dropdown.Link>
                                    )}
                                </Dropdown.Content>
                            </Dropdown>
                        </div>
                    </div>
                </div>

                {/* Header */}
                {header && (
                    <header className="mt-16 bg-white shadow dark:bg-gray-800">
                        <div className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                            {header}
                        </div>
                    </header>
                )}

                {/* Main Content */}
                <main className="mt-4 p-4">{children}</main>
            </div>
        </div>
    );
}

import ApplicationLogo from "@/Components/ApplicationLogo";
import NavLink from "@/Components/NavLink";
import { Link, usePage } from "@inertiajs/inertia-react";
import Dropdown from "@/Components/Dropdown";
import { useEffect, useState } from "react";
import NotificationDropdown from "@/Components/NotificationDropdown";

function Navbar() {
    let { auth, channels } = usePage().props;

    return (
        <nav className="bg-white border-b">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between h-16 flex-1">
                    <div className="flex flex-1">
                        <div className="shrink-0 flex items-center">
                            <Link href="/">
                                <ApplicationLogo className="block h-9 w-auto text-gray-500" />
                            </Link>
                        </div>

                        <div className="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex flex-1 justify-between">
                            <div className="flex items-center space-x-2">
                                <Dropdown>
                                    <Dropdown.Trigger>
                                        <button className="px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 flex items-center">
                                            Browse
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                className="h-4 w-4 ml-2"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fillRule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clipRule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </Dropdown.Trigger>
                                    <Dropdown.Content align="left">
                                        <Link
                                            href={`/threads/`}
                                            className="py-1.5 px-3 rounded block hover:bg-zinc-50"
                                        >
                                            All threads
                                        </Link>

                                        <Link
                                            href={`/threads?popularity`}
                                            className="py-1.5 px-3 rounded block hover:bg-zinc-50"
                                        >
                                            Popular threads
                                        </Link>

                                        <Link
                                            href={`/threads?unanswered`}
                                            className="py-1.5 px-3 rounded block hover:bg-zinc-50"
                                        >
                                            Unanswered threads
                                        </Link>
                                    </Dropdown.Content>
                                </Dropdown>
                                {auth.user && (
                                    <NavLink
                                        href={route("threads.create")}
                                        active={route().current(
                                            "threads.create"
                                        )}
                                    >
                                        New Thread
                                    </NavLink>
                                )}
                                <div className="flex items-center">
                                    <Dropdown>
                                        <Dropdown.Trigger>
                                            <button className="px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 flex items-center">
                                                Channels
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    className="h-4 w-4 ml-2"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fillRule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clipRule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </Dropdown.Trigger>
                                        <Dropdown.Content align="left">
                                            {channels.map((channel) => (
                                                <Link
                                                    key={channel.id}
                                                    href={`/threads/${channel.slug}`}
                                                    className="py-1.5 px-3 rounded block hover:bg-zinc-50"
                                                >
                                                    {channel.name}
                                                </Link>
                                            ))}
                                        </Dropdown.Content>
                                    </Dropdown>
                                </div>
                            </div>

                            <div className="flex space-x-2">
                                {!auth.user ? (
                                    <>
                                        <NavLink
                                            href={route("login")}
                                            active={route().current("login")}
                                        >
                                            Login
                                        </NavLink>
                                        <NavLink
                                            href={route("register")}
                                            active={route().current("register")}
                                        >
                                            Register
                                        </NavLink>
                                    </>
                                ) : (
                                    <div className="flex items-center space-x-3">
                                        {auth.user && <NotificationDropdown />}
                                        <Dropdown>
                                            <Dropdown.Trigger>
                                                <button className="px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 flex items-center">
                                                    {auth.user.name}
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        className="h-4 w-4 ml-2"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fillRule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clipRule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </Dropdown.Trigger>
                                            <Dropdown.Content>
                                                <Link
                                                    href="/logout"
                                                    className="py-1.5 px-3 rounded block hover:bg-zinc-50 w-full text-left"
                                                    method="post"
                                                    as="button"
                                                >
                                                    Logout
                                                </Link>

                                                <Link
                                                    href={`/profiles/${auth.user.name}`}
                                                    className="py-1.5 px-3 rounded block hover:bg-zinc-50"
                                                >
                                                    Profile
                                                </Link>
                                            </Dropdown.Content>
                                        </Dropdown>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    );
}

function Flash({ message }) {
    let [isVisibile, setIsVisibile] = useState(message && true);

    useEffect(() => {
        if (message) {
            setIsVisibile(true);
            setTimeout(() => setIsVisibile(false), 2000);
        }
    }, [message]);

    return (
        isVisibile && (
            <div className="fixed bg-blue-500 text-white text-sm py-2.5 px-4 rounded-md font-semibold bottom-5 right-5">
                {message}
            </div>
        )
    );
}

function Layout(page) {
    let message = page.props.flash.message;

    return (
        <div>
            <Navbar />
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">{page}</div>
            <Flash message={page.props.flash.message} />
        </div>
    );
}

export default Layout;

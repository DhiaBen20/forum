import { Link, useForm, usePage } from "@inertiajs/react";
import Dropdown from "./Dropdown";
import { SolidBellIcon } from "./icons";

function Notification({
    notification: {
        data: { message, link },
        id,
    },
}) {
    let { get, delete: destroy } = useForm();
    let { auth } = usePage().props;

    function handleClick() {
        destroy(`/profiles/${auth.user.name}/notifications/${id}`, {
            onSuccess: () => get(link),
        });
    }

    return (
        <button
            className="py-1.5 px-3 rounded block hover:bg-zinc-50 w-full text-left"
            onClick={handleClick}
        >
            {message}
        </button>
    );
}

function NotificationDropdown() {
    let { notifications } = usePage().props;

    return (
        <Dropdown>
            <Dropdown.Trigger>
                <button className="px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 flex items-center">
                    <SolidBellIcon />
                </button>
            </Dropdown.Trigger>
            <Dropdown.Content width="w-72">
                {notifications.length ? (
                    notifications.map((notification) => (
                        <Notification
                            key={notification.id}
                            notification={notification}
                        />
                    ))
                ) : (
                    <div className="text-center text-sm py-2">
                        You have no unread notifications
                    </div>
                )}
            </Dropdown.Content>
        </Dropdown>
    );
}

export default NotificationDropdown;

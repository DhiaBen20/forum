import { Link, usePage } from "@inertiajs/inertia-react";
import { useState } from "react";
import Dropdown from "./Dropdown";
import { DotsIcon } from "./icons";
import SubscribeButton from "./SubscribeButton";

function ThreadDropdown({ threadPath }) {
    let { can, thread } = usePage().props;

    let [isSubscribed, setIsSubscribed] = useState(thread.isSubscribedTo);

    return (
        <Dropdown>
            <Dropdown.Trigger>
                <button className="px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 flex items-center">
                    <DotsIcon />
                </button>
            </Dropdown.Trigger>

            <Dropdown.Content width="w-60">
                {can.delete_thread && (
                    <Link
                        href={threadPath}
                        className="py-1.5 px-3 rounded block hover:bg-zinc-50 w-full text-left"
                        method="delete"
                        as="button"
                    >
                        Delete Thread
                    </Link>
                )}

                <SubscribeButton
                    isSubscribed={isSubscribed}
                    setIsSubscribed={setIsSubscribed}
                    id={thread.id}
                />
            </Dropdown.Content>
        </Dropdown>
    );
}

export default ThreadDropdown;

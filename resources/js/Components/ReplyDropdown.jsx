import { Link } from "@inertiajs/inertia-react";
import Dropdown from "./Dropdown";
import { DotsIcon } from "./icons";

function ReplyDropdown({ canUpdateReply, href, setIsEditing }) {
    return (
        <Dropdown>
            <Dropdown.Trigger>
                <button className="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 flex items-center">
                    <DotsIcon />
                </button>
            </Dropdown.Trigger>
            <Dropdown.Content>
                {canUpdateReply && (
                    <>
                        <button
                            className="py-1.5 px-3 rounded block hover:bg-zinc-50 w-full text-left"
                            onClick={() => setIsEditing(true)}
                        >
                            Edit Reply
                        </button>
                        <Link
                            href={href}
                            className="py-1.5 px-3 rounded block hover:bg-zinc-50 w-full text-left"
                            method="delete"
                            as="button"
                        >
                            Delete Reply
                        </Link>
                    </>
                )}
            </Dropdown.Content>
        </Dropdown>
    );
}

export default ReplyDropdown;

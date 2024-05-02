import Pagination from "@/Components/Pagination";
import Reply from "@/Components/Reply";
import ReplyForm from "@/Components/ReplyForm";
import ThreadDropdown from "@/Components/ThreadDropdown";
import { Link } from "@inertiajs/react";
import moment from "moment";

function Show({ thread, channel, replies }) {
    return (
        <div className="">
            <div className="bg-white mt-10 rounded-md p-3 shadow-sm">
                <div className="flex justify-between xitems-center">
                    <h1 className="font-semibold text-2xl mb-4">
                        {thread.title}
                    </h1>

                    <ThreadDropdown
                        threadPath={`/threads/${channel.slug}/${thread.id}`}
                    />
                </div>
                <span className="text-gray-500">
                    By{" "}
                    <Link
                        href={`/profiles/${thread.author.name}`}
                        className="font-semibold text-gray-700"
                    >
                        {thread.author.name}
                    </Link>{" "}
                    <time>{moment(thread.created_at).fromNow()}</time>
                </span>
                <p className="mt-6">{thread.body}</p>
            </div>

            <h3 className="font-semibold text-xl my-6">
                Comments{" "}
                <span className="text-base text-gray-600">{replies.total}</span>
            </h3>

            <div className="space-y-2">
                {replies.data.map((reply) => (
                    <Reply key={reply.id} reply={reply} />
                ))}
            </div>

            <Pagination paginator={replies} />

            <ReplyForm />
        </div>
    );
}

export default Show;

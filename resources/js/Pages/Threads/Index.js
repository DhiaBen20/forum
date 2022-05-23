import { Link } from "@inertiajs/inertia-react";

function Index({ threads }) {
    console.log(threads);
    return (
        <div className="space-y-4">
            <h2 className="font-semibold text-2xl mt-10 mb-8">
                Latest Threads
            </h2>
            {threads.map((thread) => (
                <div
                    key={thread.id}
                    className="bg-white rounded-lg px-6 py-3 border-zinc-100 shadow-sm xborder"
                >
                    <h2 className="font-semibold text-lg text-gray-800">
                        <Link
                            href={`/threads/${thread.channel.slug}/${thread.id}`}
                        >
                            {thread.title}
                        </Link>
                    </h2>
                    <p className="text-sm text-gray-700 mt-2">{thread.body}</p>

                    <div className="flex items-center text-gray-600 mt-3">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            className="h-6 w-6 mr-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            strokeWidth={2}
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"
                            />
                        </svg>
                        {thread.replies_count}
                    </div>
                </div>
            ))}
        </div>
    );
}

export default Index;

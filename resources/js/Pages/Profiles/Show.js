import { Link } from "@inertiajs/inertia-react";
import moment from "moment";
import { createElement } from "react";

function ActivityCard(props) {
    return <div className="bg-white rounded-md py-2 px-4 shadow" {...props} />;
}

function ThreadActivity({ name, subject }) {
    return (
        <ActivityCard>
            {name} published a{" "}
            <Link
                href={`/threads/${subject.channel.slug}/${subject.id}`}
                className="font-semibold"
            >
                thread
            </Link>
            .
        </ActivityCard>
    );
}

function ReplyActivity({ name, subject }) {
    return (
        <ActivityCard>
            {name} replied to a{" "}
            <Link
                href={`/threads/${subject.thread.channel.slug}/${subject.thread.id}`}
                className="font-semibold"
            >
                thread
            </Link>
            .
        </ActivityCard>
    );
}

function FavoriteActivity({ name, subject }) {
    let isThread = subject.subject_type === '"App\\Models\\Thread"';
    let href = `/threads/${
        isThread
            ? subject.favorited.channel.slug
            : subject.favorited.thread.channel.slug
    }/${isThread ? subject.favorited_id : subject.favorited.thread_id}${
        !isThread && "#reply-" + subject.favorited_id
    }`;

    console.log(href);

    return (
        <ActivityCard>
            {name} favorited a{" "}
            <Link href={href} className="font-semibold">
                {isThread ? "thread" : "reply"}
            </Link>
            .
        </ActivityCard>
    );
}

function Show({ profile, activities }) {
    let activityCards = {
        created_thread: ThreadActivity,
        created_reply: ReplyActivity,
        created_favorite: FavoriteActivity,
    };

    return (
        <div className="mt-10">
            <h1 className="text-xl mb-6 font-semibold">
                {profile.name}
                <span className="text-sm font-normal ml-2">
                    created at {moment(profile.created_at).format("MMMM Y")}
                </span>
            </h1>

            <div className="space-y-3">
                {Object.entries(activities).map(([date, activities]) => (
                    <div className="space-y-3" key={date}>
                        <h3 className="mb-2 text-md font-semibold">{date}</h3>
                        {activities.map((activity) =>
                            createElement(activityCards[activity.type], {
                                subject: activity.subject,
                                name: profile.name,
                                key: activity.id,
                            })
                        )}
                    </div>
                ))}
            </div>
        </div>
    );
}

export default Show;

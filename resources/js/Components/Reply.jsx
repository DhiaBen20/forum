import { Link, useForm } from "@inertiajs/react";
import moment from "moment";
import { useState } from "react";
import Button from "./Button";
import FavoriteButton from "./FavoriteButton";
import ReplyDropdown from "./ReplyDropdown";
import Textarea from "./Textarea";

function Reply({ reply }) {
    let [isEditing, setIsEditing] = useState(false);
    let { data, setData, patch } = useForm({ body: reply.body });

    function handleSubmit(e) {
        e.preventDefault();

        patch(`/replies/${reply.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                setIsEditing(false);
            },
        });
    }

    function handleCancelClick() {
        setData("body", reply.body);
        setIsEditing(false);
    }

    return (
        <div
            className="rounded-md p-3 bg-white shadow-sm"
            id={`reply-${reply.id}`}
        >
            <div className="flex items-start justify-between">
                <h3 className="mb-2">
                    <Link
                        href={`/profiles/${reply.owner.name}`}
                        className="font-semibold text-gray-700"
                    >
                        {reply.owner.name}
                    </Link>
                    <time className="text-sm ml-1">
                        {moment(reply.created_at).fromNow()}
                    </time>
                </h3>

                <ReplyDropdown
                    canUpdateReply={reply.canUpdateReply}
                    href={`/replies/${reply.id}`}
                    setIsEditing={setIsEditing}
                />
            </div>
            {isEditing ? (
                <form onSubmit={handleSubmit}>
                    <Textarea
                        name="body"
                        value={data.body}
                        handleChange={(e) => setData("body", e.target.value)}
                    />
                    <div className="mt-3 space-x-2">
                        <Button>Update</Button>
                        <button type="button" onClick={handleCancelClick}>
                            Cancel
                        </button>
                    </div>
                </form>
            ) : (
                <>
                    <p>{reply.body}</p>

                    <div className="mt-3">
                        <FavoriteButton
                            favorited={reply.isFavorited}
                            favoritesCount={reply.favoritesCount}
                            endpoint={`/replies/${reply.id}/favorites`}
                        />
                    </div>
                </>
            )}
        </div>
    );
}

export default Reply;

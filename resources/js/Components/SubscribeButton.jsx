import { useForm } from "@inertiajs/inertia-react";

function SubscribeButton({ isSubscribed, setIsSubscribed, id }) {
    let { post, delete: destroy } = useForm();

    function handleClick() {
        setIsSubscribed((state) => !state);

        let action = isSubscribed ? destroy : post;

        action(`/threads/${id}/subscriptions`);
    }

    return (
        <button
            className={`py-1.5 px-3 rounded  w-full text-left flex items-center justify-between ${
                isSubscribed ? "bg-slate-100" : "hover:bg-zinc-50"
            }`}
            onClick={handleClick}
        >
            {isSubscribed ? "Unsubscribe from thread" : "Subscribe to thread"}
        </button>
    );
}

export default SubscribeButton;

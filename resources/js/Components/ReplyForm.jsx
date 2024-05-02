import { Link, useForm, usePage } from "@inertiajs/react";
import Button from "./Button";
import Label from "./Label";
import Textarea from "./Textarea";

function ReplyForm() {
    let { auth, thread } = usePage().props;
    let { post, setData, reset, data } = useForm({ body: "" });

    function handleSubmit(e) {
        e.preventDefault();

        post(`/threads/${thread.id}/replies`, {
            preserveScroll: true,
            onSuccess: () => reset("body"),
        });
    }

    return auth.user ? (
        <div>
            <h3 className="font-semibold text-xl my-6">Add a reply</h3>
            <form onSubmit={handleSubmit}>
                <div>
                    <Label forInput="reply">Reply</Label>
                    <Textarea
                        className="mt-2"
                        id="reply"
                        value={data.body}
                        handleChange={(e) => setData("body", e.target.value)}
                    ></Textarea>
                </div>

                <Button className="mt-5">Post</Button>
            </form>
        </div>
    ) : (
        <p className="text-center my-5 text-gray-600">
            Please{" "}
            <Link href="/login" className="font-semibold">
                sign in
            </Link>{" "}
            to participate in this discussion
        </p>
    );
}

export default ReplyForm;

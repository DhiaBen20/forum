import Button from "@/Components/Button";
import Input from "@/Components/Input";
import Label from "@/Components/Label";
import Textarea from "@/Components/Textarea";
import { useForm } from "@inertiajs/inertia-react";

function ErrorMessage({ children }) {
    return (
        <span className="text-red-500 text-sm font-semibold">{children}</span>
    );
}

function Create({ channels, errors }) {
    let { setData, post, reset } = useForm({
        title: "",
        body: "",
        channel_id: "",
    });

    console.log(errors);

    function handleChange(e, field) {
        setData(field, e.target.value);
    }

    function handleSubmit(e) {
        e.preventDefault();

        post(`/threads`, {
            onSuccess: () => reset("channel", "title", "body"),
        });
    }

    return (
        <div className="max-w-2xl">
            <h2 className="font-bold text-2xl my-8">Create a New Thread</h2>

            <form onSubmit={handleSubmit}>
                <div className="space-y-4">
                    <div>
                        <Label className="mb-2" forInput="channel">
                            Channels
                        </Label>

                        <select
                            onChange={(e) => handleChange(e, "channel_id")}
                            id="channel"
                            className="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                            <option></option>
                            {channels.map((channel) => (
                                <option key={channel.id} value={channel.id}>
                                    {channel.name}
                                </option>
                            ))}
                        </select>
                        <ErrorMessage>{errors.channel_id}</ErrorMessage>
                    </div>
                    <div>
                        <Label className="mb-2" forInput="title">
                            Title
                        </Label>
                        <Input
                            onChange={(e) => handleChange(e, "title")}
                            className="w-full"
                            id="title"
                        />
                        <ErrorMessage>{errors.title}</ErrorMessage>
                    </div>
                    <div>
                        <Label className="mb-2" forInput="body">
                            Body
                        </Label>
                        <Textarea
                            onChange={(e) => handleChange(e, "body")}
                            className="w-full"
                            id="body"
                            rows="4"
                        />
                        <ErrorMessage>{errors.body}</ErrorMessage>
                    </div>
                </div>
                <Button className="mt-8">Post</Button>
            </form>
        </div>
    );
}

export default Create;

import { useForm } from "@inertiajs/inertia-react";
import { useState } from "react";
import { HeartIcon, SolidHeartIcon } from "./icons";

function FavoriteButton({ favorited, favoritesCount, endpoint }) {
    let [isFavorited, setIsFavorited] = useState(favorited);
    let { post, delete: destroy, reset } = useForm();

    function run(action) {
        action(endpoint, {
            preserveScroll: true,
            onSuccess: () => {
                setIsFavorited((state) => !state);
                reset();
            },
        });
    }

    function handleFavoriteClick() {
        let action = isFavorited ? destroy : post;

        run(action);
    }

    return (
        <button onClick={handleFavoriteClick} className="flex items-center">
            {isFavorited ? <SolidHeartIcon /> : <HeartIcon />}
            <span className="text-sm ml-2">{favoritesCount}</span>
        </button>
    );
}

export default FavoriteButton;

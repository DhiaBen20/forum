import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";
import "../css/app.css";
import Layout from "./Layouts/Layout";

createInertiaApp({
    resolve(name) {
        const pages = import.meta.glob("./Pages/**/*.jsx", { eager: true });

        const page = pages[`./Pages/${name}.jsx`];

        if (name.includes("Login") || name.includes("Register")) {
            page.default.layout = null;
        } else {
            page.default.layout = (page) => <Layout>{page}</Layout>;
        }

        return page;
    },

    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },

    progress: {
        color: "#4B5563",
    },
});

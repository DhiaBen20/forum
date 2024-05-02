require("./bootstrap");

import React from "react";
import { render } from "react-dom";
import { createInertiaApp } from '@inertiajs/react'
import Layout from "@/Layouts/Layout";
const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,

    resolve: (name) => {
        let page = require(`./Pages/${name}`).default;

        page.layout =
            page.name == "Login" || page.name == "Register"
                ? null
                : page.layout || Layout;

        return page;
    },

    setup({ el, App, props }) {
        return render(<App {...props} />, el);
    },

    progress: {
        color: '#4B5563'
    }
});
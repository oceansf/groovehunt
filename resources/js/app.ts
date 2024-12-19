import "../css/app.css";
import "./bootstrap";

import { createInertiaApp, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createApp, DefineComponent, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import Layout from "./Layouts/Layout.vue";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        try {
            const pages = import.meta.glob<DefineComponent>(
                "./Pages/**/*.vue",
                { eager: true },
            );
            const pagePath = `./Pages/${name}.vue`;

            if (!pages[pagePath]) {
                console.error(`Page not found: ${pagePath}`);
                throw new Error(`Page not found: ${pagePath}`);
            }

            const page = pages[pagePath];

            if (!page) {
                throw new Error(`Failed to load page: ${name}`);
            }

            page.default.layout = name.startsWith("Auth/") ? undefined : Layout;
            return page;
        } catch (error) {
            console.error("Page resolution error:", error);
            throw error;
        }
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component("Link", Link)
            .mount(el);
    },
    progress: {
        color: "#006aff",
    },
});

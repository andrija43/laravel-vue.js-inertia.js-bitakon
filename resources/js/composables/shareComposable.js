"use strict";

import { reactive } from "vue";

export const share = reactive({
    preview: null,
    link: "",
    prefix: "",

    setItem(preview, link, prefix = "/prompt/") {
        this.preview = preview;
        this.link = link;
        this.prefix = prefix;
    },
});

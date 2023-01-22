if (!self.define) {
    let e, s = {};
    const i = (i, n) => (i = new URL(i + ".js", n).href, s[i] || new Promise((s => {
        if ("document" in self) {
            const e = document.createElement("script");
            e.src = i, e.onload = s, document.head.appendChild(e)
        } else e = i, importScripts(i), s()
    })).then((() => {
        let e = s[i];
        if (!e) throw new Error(`Module ${i} didn’t register its module`);
        return e
    })));
    self.define = (n, r) => {
        const t = e || ("document" in self ? document.currentScript.src : "") || location.href;
        if (s[t]) return;
        let o = {};
        const l = e => i(e, t), c = {module: {uri: t}, exports: o, require: l};
        s[t] = Promise.all(n.map((e => c[e] || l(e)))).then((e => (r(...e), o)))
    }
}
define(["./workbox-7369c0e1"], (function (e) {
    "use strict";
    self.addEventListener("message", (e => {
        e.data && "SKIP_WAITING" === e.data.type && self.skipWaiting()
    })), e.precacheAndRoute([{url: "assets/app.2a3e75ac.js", revision: null}, {
        url: "assets/app.2f47ac3e.css",
        revision: null
    }, {url: "assets/custom.bb7ea84c.js", revision: null}, {
        url: "assets/da.26fc3102.js",
        revision: null
    }, {url: "index.php", revision: "1"}, {
        url: "resources/images/favicon/512x512.png",
        revision: "87a0f18f67a3197ac6c1c709f832e264"
    }, {
        url: "manifest.webmanifest",
        revision: "207facf43954b7d8e1425396c55e02ec"
    }], {}), e.cleanupOutdatedCaches(), e.registerRoute(new e.NavigationRoute(e.createHandlerBoundToURL("index.php")))
}));

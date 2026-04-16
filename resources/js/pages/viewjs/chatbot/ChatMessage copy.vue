<template>
    <div class="chat-bubble">
        <div ref="el" class="content"></div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, nextTick } from "vue";
import MarkdownIt from "markdown-it";
import hljs from "highlight.js";

import katex from "katex";
import "katex/dist/katex.min.css";
import "highlight.js/styles/github-dark.css";

const props = defineProps({
    content: { type: String, required: true },
});

const el = ref(null);

const md = new MarkdownIt({
    html: true,
    highlight(code, lang) {
        if (lang && hljs.getLanguage(lang)) {
            return `<pre><code class="hljs">${hljs.highlight(code, { language: lang }).value}</code></pre>`;
        }
        return `<pre><code class="hljs">${hljs.highlightAuto(code).value}</code></pre>`;
    },
});

// ✅ Math renderer
function renderMath(text) {
    text = text.replace(/\$\$([\s\S]+?)\$\$/g, (_, expr) => {
        try {
            return katex.renderToString(expr, { displayMode: true });
        } catch {
            return expr;
        }
    });

    text = text.replace(/\$([^\$]+)\$/g, (_, expr) => {
        try {
            return katex.renderToString(expr, { displayMode: false });
        } catch {
            return expr;
        }
    });

    return text;
}

// ✅ Add copy buttons
function addCopyButtons() {
    const blocks = el.value.querySelectorAll("pre");

    blocks.forEach((block) => {
        // prevent duplicates
        if (block.querySelector(".copy-btn")) return;

        const button = document.createElement("button");
        button.innerText = "Copy";
        button.className = "copy-btn";

        button.onclick = async () => {
            const codeEl = block.querySelector("code");

            const text = codeEl?.textContent || "";

            await navigator.clipboard.writeText(text);

            button.innerText = "Copied!";
            setTimeout(() => (button.innerText = "Copy"), 1200);
        };

        block.style.position = "relative";
        block.appendChild(button);
    });
}

async function render() {
    if (!el.value) return;

    const withMath = renderMath(props.content || "");
    el.value.innerHTML = md.render(withMath);

    await nextTick();
    addCopyButtons(); // 🔥 attach buttons after render
}

onMounted(render);
watch(() => props.content, render);
</script>

<style>
strong {
    color: aqua;
    font-weight: bolder;
    font-size: larger;
}

.chat-bubble {
    padding: 12px;
    border-radius: 12px;
    background: #111;
    color: #eee;
    margin-bottom: 10px;
}

/* Code block */
pre {
    padding: 12px;
    overflow-x: auto;
    border-radius: 8px;
    background: #1b1b1b;
}

/* Inline code */
code {
    background: #222;
    padding: 2px 6px;
    border-radius: 4px;
}

/* ✅ Copy button */
.copy-btn {
    position: absolute;
    top: 6px;
    right: 6px;
    background: #333;
    color: #fff;
    border: none;
    padding: 4px 8px;
    font-size: 12px;
    border-radius: 6px;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.2s ease;
}

pre:hover .copy-btn {
    opacity: 1;
}

.copy-btn:hover {
    background: #555;
}
</style>

<template>
    <div class="chat-bubble">
        <div ref="el" class="content"></div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, nextTick } from "vue";
import MarkdownIt from "markdown-it";
import hljs from "highlight.js";
import mk from "markdown-it-katex";

import "katex/dist/katex.min.css";
import "highlight.js/styles/github-dark.css";

const props = defineProps({
    content: { type: String, required: true },
});

const el = ref(null);

/**
 * ✅ Markdown engine
 */
const md = new MarkdownIt({
    html: true,
    linkify: true,
    breaks: true,
    highlight(code, lang) {
        if (lang && hljs.getLanguage(lang)) {
            return `<pre><code class="hljs">${hljs.highlight(code, { language: lang }).value}</code></pre>`;
        }
        return `<pre><code class="hljs">${hljs.highlightAuto(code).value}</code></pre>`;
    },
}).use(mk); // ✅ handles math safely (no regex hacks)

/**
 * ✅ Add copy buttons to code blocks
 */
function addCopyButtons() {
    const blocks = el.value.querySelectorAll("pre");

    blocks.forEach((block) => {
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

/**
 * ✅ Render pipeline (clean + safe)
 */
async function render() {
    if (!el.value) return;

    // 1. Markdown render (includes math via plugin)
    el.value.innerHTML = md.render(props.content || "");

    await nextTick();

    // 2. Attach copy buttons AFTER render
    addCopyButtons();

      // 🔥 NEW: auto color math
  autoColorMath(el.value);
}

onMounted(render);
watch(() => props.content, render);

function autoColorMath(root) {
  const palette = [
    "#ff7b72", // red
    "#79c0ff", // blue
    "#3fb950", // green
    "#d2a8ff", // purple
    "#ffa657", // orange
    "#f2cc60", // yellow
  ];

  const colorMap = new Map();
  let colorIndex = 0;

  // select KaTeX variable nodes
  const vars = root.querySelectorAll(".katex .mord.mathnormal");

  vars.forEach((el) => {
    const symbol = el.textContent.trim();

    if (!symbol) return;

    // assign consistent color per symbol
    if (!colorMap.has(symbol)) {
      colorMap.set(symbol, palette[colorIndex % palette.length]);
      colorIndex++;
    }

    el.style.color = colorMap.get(symbol);
    el.style.fontWeight = "500";
  });
}
</script>

<style scoped>
.chat-bubble {
    padding: 12px;
    border-radius: 12px;
    background: #111;
    color: #eee;
    margin-bottom: 10px;
    font-size: 14px;
    line-height: 1.6;
}

/* headings */
h1,
h2,
h3 {
    margin-top: 10px;
}

/* links */
a {
    color: #4ea1ff;
    text-decoration: underline;
}

/* code block */
pre {
    padding: 12px;
    overflow-x: auto;
    border-radius: 8px;
    background: #1b1b1b;
}

/* inline code */
code {
    background: #222;
    padding: 2px 6px;
    border-radius: 4px;
}

/* copy button */
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

/* tables */
table {
    border-collapse: collapse;
    margin-top: 10px;
}

td,
th {
    border: 1px solid #444;
    padding: 6px 10px;
}

/* 🎯 Improve KaTeX appearance */
.katex {
    color: #e6edf3;
    font-size: 1.05em;
}

/* block math */
.katex-display {
    background: #0d1117;
    padding: 12px;
    border-radius: 10px;
    margin: 12px 0;
    overflow-x: auto;
}

/* variables (letters) */
.katex .mord.mathnormal {
    color: #79c0ff;
    /* blue */
}

/* numbers */
.katex .mord {
    color: #ffa657;
}

/* operators (=, +, -, etc.) */
.katex .mrel,
.katex .mbin {
    color: #ff7b72;
}

/* functions like sin, cos */
.katex .mop {
    color: #a5d6ff;
}

/* parentheses */
.katex .mopen,
.katex .mclose {
    color: #c9d1d9;
}

/* fractions */
.katex .mfrac .frac-line {
    border-bottom: 2px solid #58a6ff;
}

/* square roots */
.katex .sqrt>.sqrt-sign {
    color: #3fb950;
}

/* superscripts/subscripts */
.katex .msup,
.katex .msub {
    color: #d2a8ff;
}

.katex-display {
    background: linear-gradient(135deg, #0d1117, #161b22);
    border: 1px solid #30363d;
}
</style>

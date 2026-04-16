<template>
    <div class="chat-bubble">
      <div ref="el" class="content"></div>
    </div>
  </template>

  <script setup lang="ts">
  import hljs from "highlight.js";
  import MarkdownIt from "markdown-it";
  import mk from "markdown-it-katex";
  import { ref, onMounted, watch, nextTick } from "vue";

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
    html: false,
    linkify: true,
    breaks: true,
    highlight(code, lang) {
      if (lang && hljs.getLanguage(lang)) {
        return `<pre><code class="hljs">${hljs.highlight(code, { language: lang }).value}</code></pre>`;
      }

      return `<pre><code class="hljs">${hljs.highlightAuto(code).value}</code></pre>`;
    },
  }).use(mk);

  /**
   * 🔥 Auto-wrap LaTeX (so your current content renders math)
   */
  function autoWrapLatex(text) {
    if (!text) return text;

    return text
      // wrap \frac{a}{b}, \sin(x), etc.
      .replace(/(\\[a-zA-Z]+\{[^}]+\}\{[^}]+\})/g, '$$$1$$')
      // wrap simple expressions like a+b, x=2
      .replace(/([a-zA-Z0-9]+\s*[\+\-\=\>\<]\s*[a-zA-Z0-9]+)/g, '$$$1$$');
  }

  /**
   * ✅ Copy buttons
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
   * 🎨 Auto-color math variables
   */
  function autoColorMath(root) {
    const palette = [
      "#ff7b72",
      "#79c0ff",
      "#3fb950",
      "#d2a8ff",
      "#ffa657",
      "#f2cc60",
    ];

    const colorMap = new Map();
    let colorIndex = 0;

    const vars = root.querySelectorAll(".katex .mord.mathnormal");

    vars.forEach((el) => {
      const symbol = el.textContent.trim();

      if (!symbol) return;

      if (!colorMap.has(symbol)) {
        colorMap.set(symbol, palette[colorIndex % palette.length]);
        colorIndex++;
      }

      el.style.setProperty("color", colorMap.get(symbol), "important");
      el.style.fontWeight = "500";
    });
  }

  /**
   * ✅ Render pipeline
   */
  async function render() {
    if (!el.value) return;

    // 🔥 fix raw math input
    const formatted = autoWrapLatex(props.content || "");

    // render markdown
    el.value.innerHTML = md.render(formatted);

    await nextTick();

    addCopyButtons();
    autoColorMath(el.value);
  }

  onMounted(render);
  watch(() => props.content, render);
  </script>

  <style>
strong{
    font-weight: 900;
    font-size: larger;
    color: #58a6ff;
}

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
  h1, h2, h3 {
    margin-top: 10px;
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

  td, th {
    border: 1px solid #444;
    padding: 6px 10px;
  }

  /* KaTeX base */
  .katex {
    color: #e6edf3;
    font-size: 1.05em;
  }

  /* block math */
  .katex-display {
    background: linear-gradient(135deg, #0d1117, #161b22);
    border: 1px solid #30363d;
    padding: 12px;
    border-radius: 10px;
    margin: 12px 0;
    overflow-x: auto;
  }

  /* operators */
  .katex .mrel,
  .katex .mbin {
    color: #ff7b72;
  }

  /* functions */
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

  /* square root */
  .katex .sqrt > .sqrt-sign {
    color: #3fb950;
  }

  /* superscripts/subscripts */
  .katex .msup,
  .katex .msub {
    color: #d2a8ff;
  }

  /* smooth transition */
  .katex .mord.mathnormal {
    transition: color 0.2s ease;
  }
  </style>

// whatsAppFormatting.js
// Convert WhatsApp formatting <-> HTML
// Support: *bold*, _italic_, ~strike~, `code`, ```code block```, > quotes, newline

function escapeHtml(s) {
  return s
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#39;");
}

function decodeHtml(s) {
  return s
    .replace(/&lt;/g, "<")
    .replace(/&gt;/g, ">")
    .replace(/&amp;/g, "&")
    .replace(/&quot;/g, '"')
    .replace(/&#39;/g, "'");
}

// WA → HTML
function whatsappToHtml(input, opts = {}) {
  if (input == null) return "";
  const nl2br = !!opts.nl2br;
  let text = String(input);

  // protect code blocks ```
  const codeBlocks = [];
  text = text.replace(/```([\s\S]*?)```/g, (m, p1) => {
    const escaped = escapeHtml(p1);
    const token = `@@CODE_BLOCK_${codeBlocks.length}@@`;
    codeBlocks.push(`<pre><code>${escaped}</code></pre>`);
    return token;
  });

  // inline code `
  text = text.replace(/`([^`\n]+?)`/g, (m, p1) => `<code>${escapeHtml(p1)}</code>`);

  // blockquotes > ...
  text = text.replace(/(^|\n)(> .*(?:\n> .*)*)(?=$|\n)/g, (m, lines) => {
    const cleaned = lines.replace(/\n?^> /gm, "").trim();
    return `\n<blockquote>${escapeHtml(cleaned)}</blockquote>`;
  });

  // strike, italic, bold
  text = text.replace(/~([\s\S]*?)~/g, (m, p1) => `<s>${escapeHtml(p1)}</s>`);
  text = text.replace(/_([\s\S]*?)_/g, (m, p1) => `<em>${escapeHtml(p1)}</em>`);
  text = text.replace(/\*([\s\S]*?)\*/g, (m, p1) => `<strong>${escapeHtml(p1)}</strong>`);

  // restore code blocks
  text = text.replace(/@@CODE_BLOCK_(\d+)@@/g, (m, i) => codeBlocks[+i] || "");

  // newline -> <br>
  if (nl2br) {
    const preBlocks = [];
    text = text.replace(/<pre>[\s\S]*?<\/pre>/g, (m) => {
      const t = `@@PRE_${preBlocks.length}@@`;
      preBlocks.push(m);
      return t;
    });
    text = text.replace(/\r\n|\r|\n/g, "<br>");
    text = text.replace(/@@PRE_(\d+)@@/g, (m, i) => preBlocks[+i] || "");
  }

  return text.trim();
}

// HTML → WA
function htmlToWhatsapp(input) {
  if (!input) return "";
  let text = String(input);

  // code blocks
  text = text.replace(/<pre><code>([\s\S]*?)<\/code><\/pre>/gi, (m, p1) => {
    return "```" + decodeHtml(p1) + "```";
  });

  // inline code
  text = text.replace(/<code>(.*?)<\/code>/gi, (m, p1) => "`" + decodeHtml(p1) + "`");

  // bold, italic, strike
  text = text.replace(/<strong>(.*?)<\/strong>/gi, (m, p1) => `*${p1}*`);
  text = text.replace(/<em>(.*?)<\/em>/gi, (m, p1) => `_${p1}_`);
  text = text.replace(/<s>(.*?)<\/s>/gi, (m, p1) => `~${p1}~`);

  // blockquotes
  text = text.replace(/<blockquote>([\s\S]*?)<\/blockquote>/gi, (m, p1) => {
    return p1
      .split(/\r?\n/)
      .map((line) => "> " + line.trim())
      .join("\n");
  });

  // br -> newline
  text = text.replace(/<br\s*\/?>/gi, "\n");

  // remove other tags
  text = text.replace(/<\/?[^>]+(>|$)/g, "");

  return text.trim();
}

function standarNoWa(number) {  
    let input = number.replace(/[\s\-\+.,]/g, "");    // buang spasi, strip, +62, +, titik, koma
    input = input.replace(/^62/, "");                 // hapus prefix 62 kalau ada  
    return "62" + input.replace(/^0+/, "");           // selalu awali dengan 62 dan hapus leading 0
}

module.exports = {
  whatsappToHtml,
  htmlToWhatsapp,
  standarNoWa
};

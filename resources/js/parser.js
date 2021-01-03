const md = require('markdown-it');
const createPlugin = require('@hackmd/markdown-it-regexp');

const randomCase = require('random-case');
const vapor = require('vapor-text');

//BBCode
const bbBold = createPlugin(/\[b\](.*?)\[\/b\]/, (match, utils) => '<strong>' + utils.escape(match[1]) + '</strong>');

const bbItalic = createPlugin(/\[i\](.*?)\[\/i\]/, (match, utils) => '<em>' + utils.escape(match[1]) + '</em>');

const bbUnderline = createPlugin(
  /\[u\](.*?)\[\/u\]/,
  (match, utils) => '<span class="underline">' + utils.escape(match[1]) + '</span>',
);

const bbStrike = createPlugin(/\[s\](.*?)\[\/s\]/, (match, utils) => '<del>' + utils.escape(match[1]) + '</del>');

const bbImg = createPlugin(/\[img\](.*?)\[\/img\]/, (match, utils) => '<img src="' + utils.escape(match[1]) + '">');

const bbSpoiler = createPlugin(
  /\[spoiler\](.*?)\[\/spoiler\]/,
  (match, utils) => '<span class="wow baffle">' + utils.escape(match[1]) + '</span>',
);

const bbMock = createPlugin(/\[mock\](.*?)\[\/mock\]/, (match, utils) => randomCase(utils.escape(match[1])));

const bbGlitch = createPlugin(
  /\[glitch\](.*?)\[\/glitch\]/,
  (match, utils) => '<span class="spoiler">' + utils.escape(match[1]) + '</span>',
);

const bbVapor = createPlugin(/\[vapor\](.*?)\[\/vapor\]/, (match, utils) => vapor(utils.escape(match[1])));

// Rewrite some HTML elems
const htmlCite = createPlugin(/<cite>(.*?)<\/cite>/, (match, utils) => '<cite>' + utils.escape(match[1]) + '</cite>');

let parser = md({
  linkify: true,
  typographer: true,
})
  .use(bbBold)
  .use(bbItalic)
  .use(bbUnderline)
  .use(bbStrike)
  .use(bbImg)
  .use(bbSpoiler)
  .use(bbMock)
  .use(bbGlitch)
  .use(bbVapor)
  .use(htmlCite);

export default parser;

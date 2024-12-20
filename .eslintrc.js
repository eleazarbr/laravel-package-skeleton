module.exports = {
  env: {
      browser: true,
      node: true,
      es2021: true,
  },
  extends: [
      "eslint:recommended",
      "plugin:vue/vue3-recommended",
  ],
  parserOptions: {
      ecmaVersion: "latest",
      sourceType: "module",
  },
  plugins: [
      "vue",
  ],
  rules: {
    "vue/require-default-prop": "off",
    "vue/require-prop-types": "off",
    "comma-dangle": ["error", "always-multiline"],
    quotes: ["error", "double", { allowTemplateLiterals: true }],
    eqeqeq: "error",
    "max-len": ["error", { code: 100, tabWidth: 2, ignoreComments: true }],
    "no-plusplus": ["error", { allowForLoopAfterthoughts: true }],
    "vue/no-v-html": "off",
    "no-restricted-globals": ["error", "event", "fdescribe"],
    "vue/script-indent": ["error", 2, { baseIndent: 1 }],
  },
};
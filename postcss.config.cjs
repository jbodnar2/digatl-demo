module.exports = {
  plugins: [
    require("postcss-import"),
    require("autoprefixer")({ overrideBrowserslist: ["defaults"] }),
    require("postcss-preset-env")({ stage: 1 }),
  ],
};

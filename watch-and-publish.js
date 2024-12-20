const { exec } = require("child_process");

console.log("Starting watch-and-publish...");

// Execute `vite build --watch`
const viteWatch = exec("vite build --watch");

viteWatch.stdout.on("data", (data) => {
  console.log(data.toString());

  // Detect when a build is completed and run publish.
  if (data.toString().includes("built in")) {
    console.log("Build completed. Running publish...");
    exec("npm run publish", (err, stdout, stderr) => {
      if (err) {
        console.error(`Error during publish: ${err.message}`);
        return;
      }
      if (stderr) console.error(stderr);
      console.log(stdout);
    });
  }
});

viteWatch.stderr.on("data", (data) => {
  console.error(data.toString());
});

viteWatch.on("close", (code) => {
  console.log(`vite build --watch exited with code ${code}`);
});
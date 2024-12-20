const { execSync } = require("child_process");
require("dotenv").config();

const laravelAppPath = process.env.LARAVEL_APP_PATH || "../your-laravel-app";
const tagToPublish = process.env.TAG_TO_PUBLISH || "package-assets";

try {
  console.log("Building assets...");
  execSync("npm run build", { stdio: "inherit" });

  console.log("Publishing Laravel assets...");
  const command = `php ${laravelAppPath}/artisan vendor:publish --tag=${tagToPublish} --force`;
  execSync(command, { stdio: "inherit" });

  console.log("Assets published successfully!");
} catch (error) {
  console.error("Error during publish:", error.message);
  process.exit(1);
}
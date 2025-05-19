const { defineConfig } = require('cypress')

module.exports = defineConfig({
    "e2e": {
        "baseUrl": "http://localhost:8888/",
        "video": false,
        "trashAssetsBeforeRuns": false,
        "taskTimeout": 120000,
        "execTimeout": 120000,
        "defaultCommandTimeout": 6000,
        "animationDistanceThreshold": 40,
        "requestTimeout": 20000,
        "watchForFileChanges": false,
        "chromeWebSecurity": false,
        "failOnStatusCode": false,
        "redirectionLimit": 200,
        "testFiles": "**/*.js",
        "retries": 1
    }
})
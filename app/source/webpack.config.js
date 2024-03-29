const path = require("path");

module.exports = {
    mode: "development",
    entry: path.resolve(__dirname, "src/index.js"),
    output: {
        path: path.resolve(__dirname, "public"),
        filename: "main.js"
    },
    devServer: {
        port: "3000",
        static: path.resolve(__dirname, "public"),
        open: true,
        hot: true,
        liveReload: true,
        allowedHosts: [
            'finkava.com',
        ],
        historyApiFallback: {
            index: 'index.html'
        }
    },
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,    //kind of file extension this rule should look for and apply in test
                exclude: /node_modules/, //folder to be excluded
                use: 'babel-loader' //loader which we are going to use
            },
            {
                test: /\.css$/i,
                use: ["style-loader", "css-loader"],
            },
        ]
    },
    resolve: {
        modules: ['node_modules'],
        extensions: [".js", ".json", ".jsx", ".css"]
    }
}

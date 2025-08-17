require('dotenv').config();

module.exports = {
  apps: [
    {
      name: process.env.APP_NAME || 'ConvensionalProd',
      port: process.env.APP_PORT || 3003,      
      exec_mode: 'cluster',
      max_memory_restart: "1024M",
      instances: '2',
      script: './.output/server/index.mjs',
      node_args: '--max-old-space-size=4096'
    }
  ]
}


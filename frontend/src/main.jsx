import React from 'react'
import ReactDOM from 'react-dom/client'

import App from './App'

import 'bootstrap/dist/css/bootstrap.min.css';
import '/src/style/scss/custom.scss'
import '/src/style/css/index.css'

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,
)

import React from 'react'
import ReactDOM from 'react-dom/client'

import App from '/src/components/App.jsx'

import 'bootstrap/dist/css/bootstrap.min.css';
import '/src/assets/style/index.css'
import '/src/assets/style/scss/custom.scss'

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,
)

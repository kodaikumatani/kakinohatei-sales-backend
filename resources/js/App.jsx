import * as React from 'react';
import * as ReactDOM from 'react-dom/client';
import Dashboard from './dashboard/pages/Dashboard';

ReactDOM.createRoot(document.querySelector("#app")).render(
    <React.StrictMode>
        <Dashboard />
    </React.StrictMode>
);

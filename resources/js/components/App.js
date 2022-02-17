import ReactDOM from 'react-dom';
import Dashboard from './molecular/Dashboard';

export default function App() {
  return (
    <Dashboard />
  );
}

ReactDOM.render(
  <App />,
  document.querySelector('#app')
);
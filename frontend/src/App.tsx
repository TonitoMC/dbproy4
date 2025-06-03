import { useState, useEffect } from 'react' // Import useEffect
import reactLogo from './assets/react.svg'
import viteLogo from '/vite.svg'
import './App.css'

function App() {
  const [count, setCount] = useState(0)
  const [pingResponse, setPingResponse] = useState('Loading...') // State to hold the ping response

  // useEffect to run code after the component renders
  useEffect(() => {
    const fetchPing = async () => {
      try {
        // Make the API call to your Laravel backend's /ping route
        // Ensure this URL matches where your Laravel backend is running
        const response = await fetch('http://localhost:8000/ping')

        // Check if the response is successful (status code 200-299)
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.text(); // Or .json() if your /ping returns JSON
        setPingResponse(data); // Set the state with the response

      } catch (error) {
        console.error("Error fetching /ping:", error);
        setPingResponse(`Error: ${error.message}`); // Display error
      }
    };

    fetchPing(); // Call the async function
  }, []); // The empty dependency array [] means this effect runs only once after the initial render

  return (
    <>
      <div>
        <a href="https://vite.dev" target="_blank" rel="noopener noreferrer">
          <img src={viteLogo} className="logo" alt="Vite logo" />
        </a>
        <a href="https://react.dev" target="_blank" rel="noopener noreferrer">
          <img src={reactLogo} className="logo react" alt="React logo" />
        </a>
      </div>
      <h1>Vite + React</h1>
      <div className="card">
        <button onClick={() => setCount((count) => count + 1)}>
          count is {count}
        </button>
        <p>
          Edit <code>src/App.tsx</code> and save to test HMR
        </p>
      </div>

      {/* Display the ping response here */}
      <p>
        <span style={{ fontWeight: 'bold' }}>/ping says:</span> {pingResponse}
      </p>

      <p className="read-the-docs">
        Click on the Vite and React logos to learn more
      </p>
    </>
  )
}

export default App

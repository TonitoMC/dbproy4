import { useState, useEffect } from "react";
import { BrowserRouter } from "react-router";
import { AppRoutes } from "./router/routes";
import { Navbar } from "./components/navbar/Navbar";
import "./App.css";

function App() {
  return (
    <>
      <BrowserRouter>
        <Navbar />
        <AppRoutes />
      </BrowserRouter>
    </>
  );
}

export default App;

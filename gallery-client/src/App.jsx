import { BrowserRouter, Routes, Route } from "react-router-dom";
import './App.css'
import Home from './pages/Home'
import Login from './pages/Login'
import Signup from './pages/Signup'
import TagsList from "./pages/TagsList";
import { AppProvider } from "./provider/AppProvider";




function App() {

  return (
    <BrowserRouter>
      <AppProvider>

        {/* <nav>This is my navbar</nav> */}

        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/home" element={<Home />} />
          <Route path="/login" element={<Login />} />
          <Route path="/signup" element={<Signup />} />
          <Route path="/tagslist" element={<TagsList />} />
          <Route path="/*" element={<h1>Not Found</h1>} />
        </Routes>

      </AppProvider>
    </BrowserRouter>
  )
}

export default App

import React, { useEffect } from 'react'
import './style.css'
import PhotoCard from '../../components/PhotoCard'
import { useNavigate } from "react-router"

const Home = () => {

  const navigate = useNavigate()

  useEffect(() => {
    if (localStorage.getItem("user") == null) {
      navigate("/login");
    }
  }, [navigate])

  const logout = () => {
    console.log("logout")
    localStorage.removeItem("user")
    navigate("/login");
  }

  return (
    <div>

      <nav>
        <div>
          <p>first name</p>
          <p>last name</p>
        </div>
        <div>
          <button onClick={logout}>logout</button>
        </div>
      </nav>

      <section className='photos'>
        <PhotoCard />
        <PhotoCard />
        <PhotoCard />
        <PhotoCard />
      </section>

    </div>
  )
}

export default Home
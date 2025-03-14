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


  return (
    <div>
      <nav>
        <p>first name</p>
        <p>last name</p>
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
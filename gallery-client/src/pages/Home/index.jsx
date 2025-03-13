import React from 'react'
import './style.css'
import PhotoCard from '../../components/PhotoCard'

const Home = () => {
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
import React from 'react'
import './style.css'

const BASE_URL = 'http://localhost:3000'

const PhotoCard = ({ url, title, desc, handleDeletion }) => {
    return (
        <div className='photo-card'>
            <img src={`${BASE_URL}${url}`} alt={title || "Photo"} />
            <p>{title}</p>
            <p>{desc}</p>
            <button onClick={handleDeletion}>delete</button>
        </div>
    )
}

export default PhotoCard

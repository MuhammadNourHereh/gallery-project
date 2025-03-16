import React from 'react'
import './style.css'


const PhotoCard = ({ url, title, desc }) => {
    const BASE_URL = 'localhost:3000'
    return (
        <div className='photo-card'>
            <img src={`${BASE_URL}${url}`} alt={title || "Photo"} />
            <a>{BASE_URL}{url}</a>
            <p>{title}</p>
            <p>{desc}</p>
            <img src="http://localhost:3000/gallery-server/uploads/file_1742111995.002.jpeg" alt="Test Image"></img>
        </div>
    )
}

export default PhotoCard

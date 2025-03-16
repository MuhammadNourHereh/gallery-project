import React from 'react'
import './style.css'

const BASE_URL = 'http://localhost:3000'

const PhotoCard = ({ url, title, desc, handleDeletion, handleAddTag }) => {
    return (
        <div className='photo-card'>
            <span>tag1 </span>
            <span>tag2 </span>
            <span>tag3 </span>
            <img src={`${BASE_URL}${url}`} alt={title || "Photo"} />
            <p>{title}</p>
            <p>{desc}</p>
            <button onClick={handleDeletion}>delete</button>
            <button onClick={handleAddTag}>add tag</button>
        </div>
    )
}

export default PhotoCard

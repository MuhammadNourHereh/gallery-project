import React, { useEffect, useState } from 'react'
import './style.css'
import Tag from '../Tag'
import { request } from '../../utils/remote/requests'

const BASE_URL = 'http://localhost:3000'

const PhotoCard = ({ id, url, title, desc, handleDeletion, handleAttachTag, handleDetachTag }) => {
    const [tags, setTags] = useState([])

    const genTags = () => {
        return (
            <>
                {tags.map((tag, index) => {
                    return <Tag key={index} name={tag.name} color={tag.color} />
                })}
            </>
        )
    }

    useEffect(() => {
        const fetchTags = async () => {
            try {
                const res = await request('get', 'get-attached-tags', null, { photo_id: id })
                setTags(res)
            } catch (error) {
                console.error('Error fetching tags:', error)
            }
        }

        fetchTags()
    }, [])

    return (
        <div className='photo-card'>
            <div className='tags'>
                {genTags()}
            </div>
            <img src={`${BASE_URL}${url}`} alt={title || "Photo"} />
            <p>{title}</p>
            <p>{desc}</p>
            <button onClick={handleDeletion}>delete</button>
            <button onClick={handleAttachTag}>attach tag</button>
            <button onClick={handleDetachTag}>detach tag</button>
        </div>
    )
}

export default PhotoCard

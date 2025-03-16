import React, { useEffect, useState } from 'react'
import './style.css'
import Tag from '../Tag'
import { request } from '../../utils/remote/requests'

const BASE_URL = 'http://localhost:3000'

const PhotoCard = ({ id, url, title, desc, handleDeletion, handleAttachTag }) => {
    const [tags, setTags] = useState([])

    const genTags = () => {
        const handleDetachTag = (tagId) => {
            console.log(tagId);
            request('delete', 'detach-tag', { "photo_id": id, "tag_id": tagId })
        };

        return (
            <>
                {tags.map((tag) => (
                    <Tag
                        key={tag.id}
                        name={tag.name}
                        color={tag.color}
                        handleDetachTag={() => handleDetachTag(tag.id)} // Passing tag.id to the handler
                    />
                ))}
            </>
        );
    };

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
                <button onClick={handleAttachTag}>+</button>
                {genTags()}
            </div>
            <img src={`${BASE_URL}${url}`} alt={title || "Photo"} />
            <p className='title'>{title}</p>
            <p className='desc'>{desc}</p>
            <button onClick={handleDeletion}>delete</button>

        </div>
    )
}

export default PhotoCard

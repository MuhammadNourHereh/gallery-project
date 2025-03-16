import React, { useContext, useEffect, useState } from 'react'
import './style.css'
import Tag from '../Tag'
import { request } from '../../utils/remote/requests'
import { AppContext } from '../../provider/AppProvider'

const BASE_URL = 'http://localhost:3000'

const PhotoCard = ({ id, url, title, desc, handleDeletion }) => {
    const [attachedTags, setAttechedTags] = useState([])
    const [attachedTagsUpdated, setAttechedTagsUpdated] = useState(false);
    const { tags } = useContext(AppContext)
    const genTags = () => {
        const handleDetachTag = async (tagId) => {
            console.log(tagId);
            await request('delete', 'detach-tag', { "photo_id": id, "tag_id": tagId })
            setAttechedTagsUpdated(prev => !prev)
        };

        return (
            <>
                {attachedTags.map((tag) => (
                    <Tag
                        key={tag.id}
                        name={tag.name}
                        color={tag.color}
                        handleDetachTag={() => handleDetachTag(tag.id)}
                    />
                ))}
            </>
        );
    };
    const openDialog = () => {
        console.log("openDialog")
        setDialogOpen(true)
    }

    const handleAttachTag = async (tagId) => {
        await request('post', 'attach-tag', { "photo_id": id, "tag_id": tagId })
        setAttechedTagsUpdated(prev => !prev)
    }

    useEffect(() => {
        const fetchTags = async () => {
            try {
                const res = await request('get', 'get-attached-tags', null, { photo_id: id })
                setAttechedTags(res)
            } catch (error) {
                console.error('Error fetching tags:', error)
            }
        }

        fetchTags()
    }, [attachedTagsUpdated])

    const [dialogOpen, setDialogOpen] = useState(false)

    return (
        <div className='photo-card'>
            <div className='tags'>
                <button onClick={openDialog}>+</button>
                {genTags()}
            </div>
            <img src={`${BASE_URL}${url}`} alt={title || "Photo"} />
            <p className='title'>{title}</p>
            <p className='desc'>{desc}</p>
            <button onClick={handleDeletion}>delete</button>
            <dialog open={dialogOpen}>
                <p>attach tags</p>
                <ul>
                    {
                        tags.map(tag => {
                            return (
                                <li key={tag.id} onClick={() => handleAttachTag(tag.id)}>
                                    {tag.name}
                                </li>
                            )
                        })
                    }
                </ul>
                <button onClick={() => setDialogOpen(false)}>close</button>
            </dialog>
        </div>
    )
}

export default PhotoCard

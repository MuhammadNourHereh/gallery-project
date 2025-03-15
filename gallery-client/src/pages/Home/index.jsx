import React, { useEffect, useState } from 'react'
import './style.css'
import PhotoCard from '../../components/PhotoCard'
import { useNavigate } from "react-router"
import { request } from '../../utils/remote/requests'
import UserInput from '../../components/UserInput'

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



  const tagsGen = () => {
    const [tags, setTags] = useState([{ "id": 1, "name": "a", color: 0 }]);

    useEffect(() => {
      const a = async () => {
        try {
          const res = await request("post", "get-tags", { owner: "abc" });
          console.log(res);
          setTags(res); // Ensure res.data is an array
        } catch (error) {
          console.error("Error fetching tags:", error);
        }
      }
      a()
    }, []);
    return (
      <>
        {tags.map((v) => (
          <p key={v.id} style={{ color: `#${v.color.toString(16).padStart(6, '0')}` }}>
            {v.name}
          </p>
        ))}
      </>
    );
  };

  // add tag
  const [tagName, setTagName] = useState("")
  const [tagColor, setTagColor] = useState(0)
  const addTag = () => {
    request("post", "create-tag", { "name": tagName, "color": tagColor, "owner": "abc" });
  }
  const handleSetTagColor = (e) => {
    const hexColor = e.target.value.replace("#", ""); // Remove '#' from color
    setTagColor(parseInt(hexColor, 16)); // Convert hex to decimal
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
        <PhotoCard />
        <PhotoCard />
        <PhotoCard />
      </section>
      <hr />
      <section>
        {tagsGen()}
        <hr />
      </section>
      <section>

        <UserInput inputName="tag" setState={setTagName}/>
        <input type='color' name='color' onChange={handleSetTagColor}/><br />
        <button onClick={addTag}>add tag</button>
      </section>
    </div>
  )
}

export default Home
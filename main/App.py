import streamlit as st
import requests
import json
from PIL import Image
from Classifier import KNearestNeighbours

# Set page configuration at the very beginning
st.set_page_config(page_title="Movie Recommender System")

# Replace with your actual OMDB API key
API_KEY = "4fe01f52"

# Load data
with open('C:/xampp/htdocs/clone/Movie_Recommender_7th-sem/main/Data/movie_data.json', 'r+', encoding='utf-8') as f:
    data = json.load(f)
with open('C:/xampp/htdocs/clone/Movie_Recommender_7th-sem/main/Data/movie_titles.json', 'r+', encoding='utf-8') as f:
    movie_titles = json.load(f)

# Custom CSS for background color
page_bg_color = """
<style>
    .stApp {
        background-color: #000000;
    }
</style>
"""
st.markdown(page_bg_color, unsafe_allow_html=True)

def fetch_movie_info_from_api(movie_title):
    url = f"http://www.omdbapi.com/?t={movie_title}&apikey={API_KEY}"
    response = requests.get(url)
    if response.status_code == 200:
        return response.json()
    else:
        return None

def get_movie_info(movie_title):
    movie_info = fetch_movie_info_from_api(movie_title)
    
    if movie_info and movie_info['Response'] == 'True':
        movie_director = f"Director: {movie_info.get('Director', 'N/A')}"
        movie_cast = f"Cast: {movie_info.get('Actors', 'N/A')}"
        movie_story = f"Plot: {movie_info.get('Plot', 'N/A')}"
        movie_rating = f"IMDB Rating: {movie_info.get('imdbRating', 'N/A')}⭐"
        poster_url = movie_info.get('Poster', None)
        
        return movie_director, movie_cast, movie_story, movie_rating, poster_url
    else:
        return "Error", "Error", "Error", "Error", None

def display_movie_poster(poster_url):
    if poster_url:
        image = Image.open(requests.get(poster_url, stream=True).raw)
        st.image(image, use_column_width=False)
    else:
        st.error("Movie poster not found.")

def KNN_Movie_Recommender(test_point, k):
    target = [0 for _ in movie_titles]
    model = KNearestNeighbours(data, target, test_point, k=k)
    model.fit()
    table = []
    for i in model.indices:
        table.append([movie_titles[i][0], movie_titles[i][2], data[i][-1]])
    print(table)
    return table

def run():
    img1 = Image.open('C:/xampp/htdocs/clone/Movie_Recommender_7th-sem/main/meta/logo.jpg')
    img1 = img1.resize((250, 250))
    st.image(img1, use_column_width=False)
    st.title("Movie Recommender")
    
    genres = ['Action', 'Adventure', 'Animation', 'Biography', 'Comedy', 'Crime', 'Documentary', 'Drama', 'Family',
              'Fantasy', 'Film-Noir', 'Game-Show', 'History', 'Horror', 'Music', 'Musical', 'Mystery', 'News',
              'Reality-TV', 'Romance', 'Sci-Fi', 'Short', 'Sport', 'Thriller', 'War', 'Western']
    movies = [title[0] for title in movie_titles]
    category = ['--Select--', 'Movie based', 'Genre based']
    
    cat_op = st.selectbox('Select Recommendation Type', category)
    
    if cat_op == category[0]:
        st.warning('Please select Recommendation Type!!')
    elif cat_op == category[1]:
        select_movie = st.selectbox('Select movie: (Recommendation will be based on this selection)', ['--Select--'] + movies)
        if select_movie == '--Select--':
            st.warning('Please select a movie!!')
        else:
            no_of_reco = st.slider('Number of movies you want Recommended:', min_value=5, max_value=20, step=1)
            genres = data[movies.index(select_movie)]
            test_points = genres
            table = KNN_Movie_Recommender(test_points, no_of_reco + 1)
            table.pop(0)
            c = 0
            st.success('Here are some of our Movies Recommendatons')
            for movie, link, ratings in table:
                c += 1
                st.markdown(f"({c}) [ {movie}]({link})")
                director, cast, story, total_rat, poster_url = get_movie_info(movie)
                display_movie_poster(poster_url)  # Display the movie poster
                st.markdown(director)
                st.markdown(cast)
                st.markdown(story)
                st.markdown(total_rat)  # Display the IMDb rating
                
    elif cat_op == category[2]:
        sel_gen = st.multiselect('Select Genres:', genres)
        if sel_gen:
            imdb_score = st.slider('Choose IMDb score:', 1, 10, 8)
            no_of_reco = st.number_input('Number of movies:', min_value=5, max_value=20, step=1)
            test_point = [1 if genre in sel_gen else 0 for genre in genres]
            test_point.append(imdb_score)
            table = KNN_Movie_Recommender(test_point, no_of_reco)
            c = 0
            st.success('Here are some of our Movies Recommendatons')
            for movie, link, ratings in table:
                c += 1
                st.markdown(f"({c}) [ {movie}]({link})")
                director, cast, story, total_rat, poster_url = get_movie_info(movie)
                display_movie_poster(poster_url)  # Display the movie poster
                st.markdown(director)
                st.markdown(cast)
                st.markdown(story)
                st.markdown(total_rat)  # Display the IMDb rating
        else:
            st.warning('Please select at least one genre!!')

run()

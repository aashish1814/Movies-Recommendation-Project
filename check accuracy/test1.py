#In movie recommender system movie based recommendations
import numpy as np
import seaborn as sns
import matplotlib.pyplot as plt
from sklearn.metrics import confusion_matrix, accuracy_score, classification_report

# Example data
user_movie = {"name": "Iron Man", "genre": ["Action", "Sci-Fi"]}
recommended_movies = [
    {"name": "Edge of Tomorrow", "genre": ["Sci-Fi", "Action"]},
    {"name": "Star Trek", "genre": ["Sci-Fi", "Adventure"]},
    {"name": "Star Trek Into Darkness", "genre": ["Sci-Fi", "Action"]},
    {"name": "Captain America: The Winter Soldier", "genre": ["Action", "Adventure"]},
    {"name": "X-Men: First Class", "genre": ["Sci-Fi", "Action"]},
    {"name": "The Avengers", "genre": ["Action", "Sci-Fi"]},
    {"name": "Guardians of the Galaxy", "genre": ["Sci-Fi", "Action"]},
    {"name": "The Fifth Element", "genre": ["Sci-Fi", "Adventure"]},
    {"name": "Star Trek II: The Wrath of Khan", "genre": ["Sci-F", "Adventure"]},
    {"name": "The Terminator", "genre": ["Action", "Sci-Fi"]},
]

# Ground truth: assuming all recommendations are relevant
true_labels = [1] * len(recommended_movies)  # All are relevant in this example

# Predicted labels based on genre match
predicted_labels = [
    1 if set(user_movie["genre"]) & set(rec_movie["genre"]) else 0
    for rec_movie in recommended_movies
]

# Define all possible labels
all_labels = [0, 1]

# Calculate metrics
conf_matrix = confusion_matrix(true_labels, predicted_labels, labels=all_labels)
accuracy = accuracy_score(true_labels, predicted_labels)
class_report = classification_report(
    true_labels, predicted_labels, labels=all_labels, target_names=["No Match", "Match"]
)

# Plot confusion matrix
plt.figure(figsize=(10, 10))

# 1. Confusion Matrix
plt.subplot(2, 1, 1)
sns.heatmap(
    conf_matrix,
    annot=True,
    fmt="d",
    cmap="coolwarm",
    cbar=False,
    xticklabels=["No Match", "Match"],
    yticklabels=["No Match", "Match"],
    annot_kws={"size": 14},
)
plt.title("Confusion Matrix", fontsize=18, weight="bold")
plt.xlabel("Predicted Label", fontsize=14)
plt.ylabel("True Label", fontsize=14)
plt.xticks(fontsize=12)
plt.yticks(fontsize=12)

# 2. Metrics Summary
plt.subplot(2, 1, 2)
metrics_text = (
    f"Accuracy: {accuracy:.2f}\n\n"
    f"Classification Report:\n"
    f"{classification_report(true_labels, predicted_labels, labels=all_labels, target_names=['No Match', 'Match'])}"
)
plt.text(0.1, 0.5, metrics_text, fontsize=12, ha="left", va="center", family="monospace", wrap=True)
plt.axis("off")

plt.tight_layout()
plt.show()
